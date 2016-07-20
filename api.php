<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}

$uid = $_SESSION['user'];

$src = $_GET['src'];

$stats = "";
$albarray = array();

if (isset($_GET['src'])) {
    $album_qry1 = "SELECT * FROM albums WHERE album_name LIKE '%$src%'";    
}
else {
    $album_qry1 = "SELECT * FROM albums";
}

$album_res1=mysql_query($album_qry1);

if ($album_res1) 
{
    $count = 0;
    while($album_row = mysql_fetch_assoc($album_res1)) {
        $count += 1;

        $aid = $album_row['album_id'];
        $aname = $album_row["album_name"];
        $arr = ["id"=>"$aid", "name"=>"$aname"]; 
        array_push($albarray, $arr);
    
    }
    if($count > 0) {        
        $stats = 'success';
    }
    else {
        $stats = 'failed - count less than equal 0';
    }
}
else {        
    $stats = 'failed - query failed $album_qry1';
}

echo json_encode(array('status' => $stats, 'albums' => $albarray));


?>


