<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="stylesheets/global.css" type="text/css" />
<link rel="stylesheet" href="stylesheets/read.css" type="text/css" />
<script type="text/javascript" src="scripts/jquery.js" />
<script type="text/javascript" src="scripts/read.js" />
<title><?php echo Settings::$Site['name']; ?></title>
</head>
<body>
	<div id="loading">Loading...</div>
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
<div id="nav">
	<div id="prev"><a href="">Older Posts</a></div>
	<div id="next"><a href="">Newer Posts</a></div>
</div>
</div>
<div id="footer">
	<a href="index.php?act=write">Write</a> -
	<a href="index.php?act=viewlog">View Admin Log</a> -
	<a href="index.php?act=login&do=logout">Logout</a>
</div>
</body>
</html>