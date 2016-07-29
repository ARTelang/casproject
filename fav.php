<?php
session_start();
if(!isset($_SESSION['user']))
{
	header("Location: home.php");
}

include_once 'dbconnect.php';

//$url = 'http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist=taylorswift&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json';

$uname=$_SESSION['user-name'];



$usid=$_SESSION['user'];
$albname=$_SESSION['album_name'];
$albnmid=$_SESSION['album_id'];
$labelnm=$_SESSION['label'];


$albmname=mysql_real_escape_string($POST['albmname']);
$albmname=trim($albmname);
$albmname_qry="SELECT album_name FROM albums WHERE album_name='$albmname'";

$api_album_qry="SELECT * FROM albums WHERE user_id='$usid'";
$api_track_qry="SELECT * FROM tracks WHERE user_id='$usid'";
$exec_album_qry= mysql_query($api_album_qry);
$exec_track_qry= mysql_query($api_track_qry);
$album_row=mysql_fetch_assoc($exec_album_qry);
$track_row=mysql_fetch_assoc($exec_track_qry);
$cnt=count($album_row);



$using=$_SESSION['sing'];

$url1 = 'http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist='.$uname.'&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json';

$content = file_get_contents($url1);
$json = json_decode($content, true);

//print_r($json['topalbums']);
$albumss = $json['topalbums']['album'];

if($json['topalbums']==null)
{
	echo "<script>alert('No such Artist present.........');
    window.location.href='http://localhost/login-registration-system/home.php'
    </script>";

}
else
{
    foreach ($albumss as $key => $album)
    {
        if (isset($album)) {
        
            $albnm = $album[name];
            $alburl = $album[url];

            $url_alb_info = 'http://ws.audioscrobbler.com/2.0/?method=album.getinfo&artist='.$uname.'&album='.$albnm.'&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json';


            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url_alb_info);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
            $content_alb_info=curl_exec($ch);
            curl_close($ch);


            $json_alb_info = json_decode($content_alb_info, true);

            $alb_obj = $json_alb_info['album'];

            $albrd = $alb_obj['wiki']['published'];
            $arr_albtracks = $alb_obj['tracks'];

            //$album_count = count($album_row);

            // check if album exist
            $alb_qry = "SELECT COUNT(album_id) as total FROM albums WHERE album_name='".$albnm."' AND user_id=".$usid;
            $alb_exec = mysql_query($alb_qry);

            if ($alb_exec) {
                
                $get_alb = mysql_fetch_assoc($alb_exec);
                if($get_alb['total'] > 0)
                {
                    echo "".$albnm."<br>";
                }
                else
                {
                    if(mysql_query("INSERT INTO albums(album_name,user_id,release_date) VALUES ('$albnm',$usid,'$albrd')"))
                    {
                        //echo "<script>alert('uploaded successfully');</script>";
                        echo "album uploaded - ".$albnm;                

                        // Get album_id
                        $albumid_qry="SELECT * FROM albums WHERE album_name='$albnm' AND user_id='$usid'";
                        $exec_albumid_qry= mysql_query($albumid_qry);
                        $row=mysql_fetch_assoc($exec_albumid_qry);

                        $albid = $row['album_id'];

                        $arr_albtracks = $json_alb_info['album']['tracks']['track'];
                        foreach($arr_albtracks as $key => $track) 
                        {
                            // Upload tracks
                            $trk_name = $track['name'];
                            $trk_url = $track['url'];
                            $trk_singer = $track['artist']['name'];

                            if(mysql_query("INSERT INTO tracks(track_name, singers, hyperlink, user_id, album_id) VALUES ('$trk_name', '$trk_singer', '$trk_url', $usid, $albid)"))
                            {
                                echo "----track uploaded - ".$trk_name;
                            }    
                        }                
                    }
                }
            }
            else {
                // alb_exec error
                echo "error in album exec...<br>";
            }
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
        <label>This are your uploads!!</label>
    </div>
    <div id="right">
    	<div id="content">
        	<a href="home.php">Home</a>
        	<a href="album.php">Album</a>
        	<a href="track.php">UploadTrack</a>
        </div>
    </div>
</div>
</body>
</html>