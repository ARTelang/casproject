<?php
session_start();
if(!isset($_SESSION['user']))
{
	header("Location: home.php");
}

include_once 'dbconnect.php';
if(isset($_POST['btn-add-album']))
{
	$ualbumname=mysql_real_escape_string($_POST['ualbumname']);
	$ulabel=mysql_real_escape_string($_POST['ulabel']);
	$ureleasedate=mysql_real_escape_string($_POST['ureleasedate']);
	$ugenre=mysql_real_escape_string($_POST['ugenre']);
	$uid=$_SESSION['user'];

	$ualbumname = trim($ualbumname);
	$ulabel = trim($ulabel);
	$ureleasedate = trim($ureleasedate);
	$ugenre = trim($ugenre);

	$chk_qry = "SELECT * FROM albums WHERE album_name='$ualbumname'";
	$exec_qry = mysql_query($chk_qry);
	$row = mysql_fetch_assoc($exec_qry);

	$count = count($row);

	if($count > 1)	{	
		echo "<script>alert('album already there');</script>";
	}
	else {
		if(mysql_query("INSERT INTO albums(album_name,label,release_date,genre,user_id) VALUES ('$ualbumname','$ulabel','$ureleasedate','$ugenre',$uid)")){
			echo "<script>alert('uploaded successfully');</script>";
		}		
		else {		
			echo "<script>alert('error in upload....');</script>";		
		}
	}
}

?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="style.css" type="text/css" />


</head>
<body>



<div id="header">
	<div id="left">
    <label>Upload album!!</label>
    </div>
    <div id="right">
    	<div id="content">
        	<a href="home.php">Home</a>
        	<a href="track.php">UploadTrack</a>
        </div>
    </div>
</div>



<center>
<div id="albums-form">
<form method="post">
<table align="center" width="30%" border="0">
<tr>
<td><input type="text" name="ualbumname" placeholder="Album Name" required /></td>
</tr>
<tr>
<td><input type="text" name="ulabel" placeholder=" Label" required /></td>
</tr>
<tr>
<td><input type="date" name="ureleasedate" placeholder="Release Date" required /></td>
</tr>
<tr>
<td><input type="text" name="ugenre" placeholder="Genre" required /></td>
</tr>

<tr>
<td><button type="submit" name="btn-add-album">Add!</button></td>
</tr>

</table>
</form>
</div>
</center>
</body>
</html>