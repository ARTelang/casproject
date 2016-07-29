<?php
session_start();
include_once 'dbconnect.php';

if(!isset($_SESSION['user']))
{
	header("Location: index.php");
}

$uid = $_SESSION['user'];

$res=mysql_query("SELECT * FROM users WHERE user_id=".$uid);
$userRow=mysql_fetch_array($res);

$popu=mysql_query("SELECT * FROM users WHERE user_id=".$uid);

$album_qry = "SELECT * FROM albums WHERE user_id=".$uid;
$album_res=mysql_query($album_qry);

$k= $userRow['user_name'];

$arr_data= array();

while ($album_row = mysql_fetch_assoc($album_res)) 
{
    $album_id = $album_row["album_id"];
    $album_name=$album_row["album_name"];

    $arr_data[$album_id] = array("Album Id" => $album_id, "Album Name" => $album_name );    

}

$arr_json_data = json_encode($arr_data);

function do_post_request($url, $data, $optional_headers = null)
{
  $params = array('http' => array(
              'method' => 'POST',
              'content' => $data
            ));
  if ($optional_headers !== null) {
    $params['http']['header'] = $optional_headers;
  }
  $ctx = stream_context_create($params);
  $fp = @fopen($url, 'rb', false, $ctx);
  if (!$fp) {
    throw new Exception("Problem with $url, $php_errormsg");
  }
  $response = @stream_get_contents($fp);
  if ($response === false) {
    throw new Exception("Problem reading data from $url, $php_errormsg");
  }
  return $response;
}

$url_pdf="";


echo $arr_json_data;

?>