<?php
session_start();
include_once 'dbconnect.php';

if(isset($_SESSION['user'])!="")
{
	//header("Location: home.php");
}
if(isset($_GET['user']) && intval($_GET['user']))
{
	$number_of_posts = isset($_GET['num']) ? intval($_GET['num']) : 10;
	$format = strtolower($_GET['format']) == 'json' ? 'json' : 'xml';
	$ussrid = intval($_GET['user']);

	$link1 = mysql_connect('localhost','root','') or die('Cannot connect to the DB');
	mysql_select_db('dbtest',$link1) or die('Cannot select the DB');

	$query1 = "SELECT album_name, user_id FROM albums WHERE user_id = $ussrid ORDER BY ID DESC LIMIT $number_of_posts";
	$result1 = mysql_query($query1,$link1) or die('Errant query:  '.$query1);

	$posts1 = array();
	if(mysql_num_rows($result1))
	{
		while($post1 = mysql_fetch_assoc($result1))
		{
			$posts1[] = array('post'=>$post1);
		}
	}

	if($format == 'json')
	{
		header('Content-type: application/json');
		echo json_encode(array('posts1'=>$posts1));
	}
	else
	{
		header('Content-type: text/xml');
		echo '<posts1>';
		foreach($posts1 as $index => $post)
		{
			if(is_array($post))
			{
				foreach($post as $key => $value)
				{
					echo '<',$key,'>';
					if(is_array($value))
					{
						foreach($value as $tag => $val)
						{
							echo '<',$tag,'>',htmlentities($val),'</',$tag,'>';
						}
					}
					echo '</',$key,'>';
				}
			}
		}
		echo '</post>';
	}
	@mysql_close($link1);

}
echo 'hello';

?>
