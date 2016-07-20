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

echo "user_id:" + $userRow['user_name'];

$album_qry = "SELECT * FROM albums WHERE user_id=".$uid;
$album_res=mysql_query($album_qry);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome - <?php echo $userRow['user_email']; ?></title>
<link rel="stylesheet" href="style.css" type="text/css" />

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

</head>
<body>
<div id="header">
	<div id="left">
    <label>Welcome to HELL!!</label>
    </div>
    <div id="right">
    	<div id="content">
        	hi' <?php echo $userRow['user_name']; ?>&nbsp;<a href="logout.php?logout">Sign Out</a>
        </div>
    </div>
</div>

<div id="body">
    <div>

    </div>   
	<div id="content">
         Here is your page<br />
       <!--  <a href =album.php>ADD ALBUMS</a> 
        <a href =track.php>ADD TRACKS</a> -->
        <div style="text-align: left;">
            <a href="album.php" class="abutton">UPLOAD ALBUMS</a>
            <a href="track.php" class="abutton">UPLOAD TRACKS</a>
            <a href="fav.php" class="abutton">SEARCH TRACKS</a>
        </div>
       
<!--
        <a href="http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist=thebeatles&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json">Link 1</a>
        <a href="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=theeagles&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json">Link 2</a>
        <a href="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=linkinpark&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json">Link 3</a>
        <a href="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=creed&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json">Link 4</a>
        <a href="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=johnmayer&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json">Link 5</a>
        <a href="http://ws.audioscrobbler.com/2.0/?method=artist.gettoptracks&artist=jasonmarz&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json">link6</a> -->
    <?php
/*
        $url_topartist = "http://ws.audioscrobbler.com/2.0/?method=tag.gettopartists&tag=pop&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json";
        $artist_json = file_get_contents($url_topartist);

        $artist_data = json_decode($artist_json, true);
        $artists = $artist_data['topartists']['artist'];

        foreach ($artists as $key => $artist) {
            $artist_name = $artist['name'];
            echo '<a href="home.php?artist='.str_replace(' ', '', strtolower($artist_name)).'">'.$artist_name.'</a> ';
        }

*/
        if (isset($_GET['artist'])) {
            $artist = $_GET['artist'];
            $json = file_get_contents('http://ws.audioscrobbler.com/2.0/?method=artist.gettopalbums&artist='.$artist.'&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json');

            $data = json_decode($json, true);
            /*
            $albums = $data['topalbums']['album'][0][artist][name];

                echo "<pre>";
                print_r($albums);
            */
            $albums = $data['topalbums']['album'];            
            foreach ($albums as $key => $album) {
                echo "<pre>";
                print_r($album[name]);          
            }
        }
    ?>
    <table width="80%" border="1" >
    <tr>
    <th colspan="4"> your albums </th>
</tr>
<tr>
    <td>Album name</td>
    <td>Label</td>
    <td>Release Date</td>
    <td>Genre</td>
    <td>View tracks</td>
    <td>Popularity</td>
</tr>
<?php

$k= $userRow['user_name'];

while ($album_row = mysql_fetch_assoc($album_res)) {
    $alb_name = $album_row["album_id"];

    echo '<tr>';
    echo    '<td>'.$album_row["album_name"].'</td>';
    echo    '<td>'.$album_row["label"].'</td>';
    echo    '<td>'.$album_row["release_date"].'</td>';
    echo    '<td>'.$album_row["genre"].'</td>';
    echo    '<td><a href="viewtracks.php?album='.$alb_name.'">View</a></td>';
    echo    '<td></td>';
    echo '</tr>';

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