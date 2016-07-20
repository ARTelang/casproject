<?php
	$uname="taylor swift";

    $albnm = "speak now";

    $url_alb_info = 'http://ws.audioscrobbler.com/2.0/?method=album.getinfo&artist='.$uname.'&album='.$albnm.'&api_key=7a5ea6e06238400dc41bc7087c07cee3&format=json';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_alb_info);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        $content_alb_info=curl_exec($ch);
        curl_close($ch);

    print_r($content_alb_info);
/*
    $alb_obj = $json_alb_info['album']['wiki'];


    $arr_albtracks = $json_alb_info['album']['tracks']['track'];


    foreach ($arr_albtracks as $key => $track) {
        
    	echo $track['name'].'<br>';
        echo $track['url'].'<br>';
        echo $track['artist']['name'].'<br>';
    } 
    
*/





?>