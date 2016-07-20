<?php
session_start();
if(isset($_SESSION['user'])!="")
{
	header("Location: home.php");
}
include_once 'dbconnect.php';
if(isset($_POST['btn-upload']))
{
	$ualbumname=mysql_real_escape_string($_POST['ualbumname']);
	$ulabel=mysql_real_escape_string($_POST['ulabel']);
	$ureleasedate=mysql_real_escape_string($_POST['ureleasedate']);
	$ugenre=mysql_real_escape_string($_POST['ugenre']);
	$ualbumid=mysql_real_escape_string($_POST['ualbumid']);

	$ualbumname = trim($ualbumname);
	$ulabel = trim($ulabel);
	$ureleasedate = trim($ureleasedate);
	$ugenre = trim($ugenre);
	$ualbumid = trim($ualbumid);	

	if($count ==0)
	{
		if(mysql_query("INSERT INTO albums(album_name,label,release_date,genre,album_id) VALUES ('$ualbumname','$ulabel','$ureleasedate','$ugenre','$ualbumid')"))
		?>
		<script>alert('uploaded successfully');</script>
		<?php
	}
	else
	{
		?>
		<script>alert('error in upload....');</script>
		<?php
	}
}
else
{
	?>
	<script>alert('album already there');</script>
	<?php
}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coding Cage - Login &amp; Registration System</title>
<link rel="stylesheet" href="style.css" type="text/css" />


</head>
<body>
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
<td><input type="text" name="ureleasedate" placeholder="Release Date" required /></td>
</tr>
<tr>
<td><input type="text" name="ugenre" placeholder="Genre" required /></td>
</tr>

<tr>
<td><button type="submit" name="btn-upload">UPLOAD!</button></td>
</tr>

</table>
</form>
</div>
</center>
</body>
</html>