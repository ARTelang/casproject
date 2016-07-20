<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}
$uid = $_SESSION['user'];
$aid = $_GET['album'];

$track_qry = "SELECT * FROM tracks WHERE album_id=".$aid." AND user_id=".$uid;
$track_res=mysql_query($track_qry);

$alb_qry = "SELECT album_name FROM albums WHERE album_id=".$aid." AND user_id=".$uid;
$alb_res=mysql_query($alb_qry);
$alb_row = mysql_fetch_assoc($alb_res);
$albnm = $alb_row['album_name'];


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" href="style.css" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
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
        	<a href="album.php">Albums</a>
        </div>
    </div>
</div>
<div id="body"> 
	<div id="content">
<?php

if ($track_res > 1) {


        
		echo '<table width="80%" border="1" >';
		echo '	<tr>';
		echo '	  <th colspan="4"> Here are the tracks for - '.$albnm.'</th>';
		echo '	</tr>';
		echo '	<tr>';
		echo '		<td>track name</td>';
		echo '	    <td>Singers</td>';
		echo '	    <td>hyperlinks</td>';
		echo '	</tr>';
	while($track_row = mysql_fetch_assoc($track_res))
	{
		echo '<tr>';
	    echo    '<td>'.$track_row["track_name"].'</td>';
	    echo    '<td>'.$track_row["singers"].'</td>';
	    echo    '<td><a target="_blank" href="'.$track_row["hyperlink"].'">Open Link</a></td>';
	    echo '</tr>';
	}
}
else {
	echo("<p>Please upload tracks from <a href='home.php'>home page</a></p>");
}


?>
  </table>
    </div>
</div>


<script>
$(document).ready(function(){
    $("button").click(function(){
        $.getJSON("demo_ajax_json.js", function(result){
            $.each(result, function(i, field){
                $("div").append(field + " ");
            });
        });
    });
});
</script>



</body>
</html>