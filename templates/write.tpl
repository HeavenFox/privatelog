<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="stylesheets/global.css" type="text/css" />
<link rel="stylesheet" href="stylesheets/read.css" type="text/css" />
<link rel="stylesheet" href="stylesheets/write.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery.js"></script>
<script type="text/javascript" src="scripts/read.js"></script>
<script type="text/javascript" src="scripts/write.js"></script>
<title><?php echo Settings::$Site['name']; ?></title>
</head>
<body>
<div id="loading">Loading...</div>
<div id="wrapper">
<div id="container">
<div id="header">
	<h1><?php echo Settings::$Site['name']; ?></h1>
</div>
<div id="main">
	<?php
	if (isset(Template::$Vars['error'])):
	?>
	<div class="error">
		<?php
		echo Template::$Vars['error'];
		?>
	</div>
	<?php
	endif;
	?>
<form method="post" action="index.php?act=write&do=post">
<div id="leftsec">
<h2>Title</h2> <input type="text" name="title" id="title" />
<h2>Content</h2>
<?php
require_once ROOT. 'editor/fckeditor/fckeditor.php';
$editor = new FCKeditor('content');
$editor->BasePath = 'editor/fckeditor/';
$editor->ToolbarSet = 'BlogPost';
$editor->Height = 500;
$editor->Create();
?>
</div>
<div id="rightsec">
<div id="time">
<h2>Time</h2>
Now <a href="javascript:specifyTime()">(Specify a time)</a>
</div>
<div id="weather">
<h2>Weather</h2>
<input type="text" name="weather" />
</div>
<div id="location">
<h2>Location</h2> <input type="text" name="location" />
</div>
<div id="location">
<h2>Key</h2>
<p>Leave blank to use current password as the key</p>
<input type="text" name="key" />
</div>
<div id="post">
<input id="btnPost" type="submit" value="Post!" />
</div>
</div>
</form>
	<div class="clear"></div>
</div>
<div id="footer">
	<p><a href="index.php?act=read">Read</a> -
	Write -
	<a href="index.php?act=viewlog">View Admin Log</a> -
	<a href="index.php?act=login&do=logout">Logout</a></p>
	<p>Powered by Private Log. Theme by <a href='http://www.neoease.com/'>NeoEase</a></p>
</div>
</div>
</div>
</body>
</html>