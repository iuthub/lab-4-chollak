<?php
	$musics=[];
	$txts=[];
	$isMain = true;
	if(isset($_REQUEST["playlist"]) && !empty($_REQUEST["playlist"])){
		$path = "songs/";
		$isMain = false;
		$i = 0;
		foreach(file($path.$_REQUEST["playlist"]) as $line){
			$musics[$i] = $path.$line;
			$i++;
		}
	}else{
		$musics = glob("songs/*.mp3");
		$txts = glob("songs/*.txt");
	}

	if(isset($_REQUEST["shuffle"]) && $_REQUEST["shuffle"] =="on"){
		shuffle($musics);
	}
	if(isset($_REQUEST["bysize"]) && $_REQUEST["bysize"] =="on"){
		sort($musics);
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
 "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<title>Music Viewer</title>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<link href="viewer.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		<div id="header">

			<h1>190M Music Playlist Viewer</h1>
			<h2>Search Through Your Playlists and Music</h2>
		</div>	
		<div id="listarea">
		<?php if(!$isMain):?>
			<a href="music.php">Back</a>
		<?php endif;?>
			<ul id="musiclist">
				<?php foreach($musics as $music):?>
				<li class="mp3item">
					<?=$music?>
					<a href="<?=$music?>"><?=basename($music)?></a>
					<?php if (filesize($music)>1048575): ?>
						(<?=round(filesize($music)/1048576,2);?> mb)
					<?php elseif(filesize($music)>1023 && filesize($music)<1048576): ?>
						(<?=round(filesize($music)/1024,2);?> kb)
					<?php else: ?>
						(<?=filesize($music);?> b - <?=($music);?>)
					<?php endif;?>
				</li>
				<?php endforeach;?>
				<?php foreach($txts as $txt):?>
				<li class="playlistitem">
					<a href="?playlist=<?=basename($txt)?>"><?=basename($txt)?></a>
				</li>
				<?php endforeach;?>
			</ul>
		</div>
	</body>
</html>
