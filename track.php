<?php
session_start();
if(!isset($_SESSION['user']))
{
	header("Location: home.php");
}
include_once 'dbconnect.php';

$uid = $_SESSION['user'];

$album_qry = "SELECT * FROM albums WHERE user_id=$uid";
$album_exec_qry = mysql_query($album_qry);
 

if(isset($_POST['btn-add-track']))
{
	$uhyperlink=mysql_real_escape_string($_POST['uhyperlink']);
	$usingers=mysql_real_escape_string($_POST['usingers']);
	$utrackname=mysql_real_escape_string($_POST['utrackname']);
	$ualbumid=mysql_real_escape_string($_POST['ualbumid']);
	
	$uhyperlink = trim($uhyperlink);
	$usingers = trim($usingers);
	$utrackname = trim($utrackname);
	$ualbumid = trim($ualbumid);

	$chk_qry = "SELECT * FROM tracks WHERE track_name='$utrackname'";
	$exec_qry = mysql_query($chk_qry);
	$row = mysql_fetch_assoc($exec_qry);
 
	$count=count($row);
	
	if($count >1)
	{
		echo "<script>alert('track already there');</script>";
	}
	else
	{
		$execqry = mysql_query("INSERT INTO tracks(track_name,singers,hyperlink,user_id,album_id) VALUES ('$utrackname','$usingers','$uhyperlink',$uid,$ualbumid)");
		if($execqry)
		{
			echo "<script>alert('upload successfully');</script>";
		}
		else
		{
			echo "err - ".mysql_error();
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
    <label>Upload Track!!</label>
    </div>
    <div id="right">
    	<div id="content">
        	<a href="home.php">Home</a>
        	<a href="album.php">UploadAlbum</a>
        </div>
    </div>
</div>


<center>
<div id="tracks-form">
<form method="post">
<table align="center" width="30%" border="0">
	<tr>
	<td>
		<select name="ualbumid">
			<?php
				echo "<option value='select...' default>Select...</option>";
				
				while($album_row = mysql_fetch_assoc($album_exec_qry))

				{
					echo "<option value='".$album_row['album_id']."'>".$album_row['album_name']."</option>";
				}
			?>
		</select>

	</td>
	</tr>
<tr>
<td><input type="text" name="uhyperlink" placeholder="load hyperlink" required /></td>
</tr>
<tr>
<td><input type="text" name="usingers" placeholder=" Singers name" required /></td>
</tr>
<tr>
<td><input type="text" name="utrackname" placeholder="track name" required /></td>
</tr>


<tr>
<td><button type="submit" name="btn-add-track">UPLOAD!</button></td>
</tr>

</table>
</form>
</div>
</center>
</body>
</html>