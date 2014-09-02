<?php
include_once 'classes/Favorites.class.php';
$var = new Favorites();
$sites = $var->getFavorites('getLinksItems');
$apps = $var->getFavorites('getAppsItems');
$articles = $var->getFavorites('getArticlesItems');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ru" lang="ru">
<head>
	<title>Наши рекомендации</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<style>
	div#header{border-bottom:1px solid black;text-align:center;width:80%}
	div#a, div#b, div#c{width:30%; height:200px;float:left}
	
</style>
</head>
<body>
	<div id='header'>
		<h1>Мы рекомендуем</h1>
	</div>
	<div id='a'>
		<h2>Полезные сайты</h2>
		<ul>
            <?php
            foreach ($sites as $site) {
                echo "<a href='$site[1]'>$site[1]</a></br>";
            }
            ?>
        </ul>
	</div>
	<div id='b'>
		<h2>Полезные приложения</h2>
		<ul>
            <?php
            foreach ($apps as $app) {
                echo "<a href='$app[1]'>$app[0]</a></br>";
            } ?>
        </ul>
	</div>
	<div id='c'>
		<h2>Полезные статьи</h2>
		<ul>
            <?php
            foreach ($articles as $article) {
                echo "<a href='$article[1]'>$article[0]</a></br>";
            }
            ?>
        </ul>
	</div>
</body>
</html>