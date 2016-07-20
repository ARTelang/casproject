<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}

$uid1 = $_SESSION['user'];

$res1=mysql_query("SELECT * FROM users WHERE user_id=".$uid1);
$userRow1=mysql_fetch_array($res1);

$album_qry1 = "SELECT * FROM albums WHERE user_id=".$uid1;
$album_res1=mysql_query($album_qry1);

 if (isset($_GET['artist'])) 
 {
    $artist1 = $_GET['artist'];
    $json1 = file_get_contents('http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist='.$artist.'&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json');

    $data1 = json_decode($json1, true);

    $albums1 = $data['topalbums']['album'];            
    foreach ($albums1 as $key => $album) 
    {
        echo "<pre>";
        print_r($album[name]); 
    }
}

$k= $userRow['user_name'];
$albarray=array();
while ($album_row = mysql_fetch_assoc($album_res1)) {
    //$alb_name = $album_row["album_id"];

    /*echo '<tr>';
    echo    '<td>'.$album_row["album_name"].'</td>';
    echo    '<td><a href="viewtracks.php?album='.$alb_name.'">View</a></td>';
    echo    '<td></td>';
    echo '</tr>';*/
   $albarray[] = $album_row["album_name"];

}
echo json_encode($albarray);


?>


