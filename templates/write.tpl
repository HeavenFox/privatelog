<?php
$edit = $id = $title = $content = $weather = $time = $location = null;
if (isset(Template::$Vars['post']))
{
	$edit = true;
	$id = Template::$Vars['post']->id;
	$title = Template::$Vars['post']->title;
	$content = Template::$Vars['post']->content;
	$weather = Template::$Vars['post']->weather;
	$time = Template::$Vars['post']->time;
	$location = Template::$Vars['post']->location;
}
?>
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
<script type="text/javascript" src="editor/ckeditor/ckeditor.js"></script>
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
	<?php
	if (isset(Template::$Vars['message'])):
	?>
	<div class="message">
		<?php
		echo Template::$Vars['message'];
		?>
	</div>
	<?php
	endif;
	?>
<form method="post" action="index.php?act=write&do=post">
<div id="leftsec">
<h2>Title</h2> <input type="text" name="title" id="title" value="<?php echo $edit ? htmlspecialchars($title) : ''; ?>"/>
<h2>Content</h2>
<textarea name="content"></textarea>
</div>
<div id="rightsec">
<div id="time">
<h2>Time</h2>
<span id="time_content">
<?php
if ($edit)
{
	echo '<input type="text" name="year" value="' . date('Y',$time) . '" />' . 
	'-<input type="text" name="month" value="' . date('n',$time) . '" />' . 
	'-<input type="text" name="day" value="' . date('j',$time) . '" />' . 
	'<input type="text" name="hour" value="' . date('H',$time) . '" />' . 
	':<input type="text" name="minute" value="' . date('i',$time) . '" />' . 
	':<input type="text" name="second" value="' . date('s',$time) . '" />';
}
else
{
?>
Now <a href="javascript:specifyTime()">(Specify a time)</a></span>
<?php
}
?>
</div>
<div id="weather">
<h2>Weather</h2>
<input type="text" name="weather" value="<?php echo $edit ? htmlspecialchars($weather) : ''; ?>" />
</div>
<div id="location">
<h2>Location</h2> <input type="text" name="location" value="<?php echo $edit ? htmlspecialchars($location) : ''; ?>"/>
</div>
<div id="key">
<h2>Key</h2>
<?php
echo $edit ? "<p>Leave blank not to change</p>" : "<p>Leave blank to use current password as the key</p>"
?>
<input type="text" name="key" onclick="showHint()" />
</div>
<div id="post">
<input id="btnPost" type="submit" value="Post!" />
</div>
</div>
<?php
echo $edit ? "<input type='hidden' name='id' value='{$id}' />" : '';
?>
</form>
	<div class="clear"></div>
</div>
<script type="text/javascript">
CKEDITOR.replace('content',
{
	toolbar: 
[
	['Source'],['PasteText','PasteWord'],['Bold','Italic','Underline','StrikeThrough','-','Subscript','Superscript','-','RemoveFormat'],['OrderedList','UnorderedList','-','Link','Unlink','-','Image','Flash','Table','Rule','Smiley','SpecialChar']
]
});
</script>
<div id="footer">
	<p><a href="index.php?act=read">Read</a> -
	Write -
	<a href="index.php?act=viewlog">View Admin Log</a> -
	<a href="index.php?act=login&do=logout">Logout</a></p>
	<p>Powered by <a href="http://code.google.com/p/privatelog/">PrivateLog</a>. Theme by <a href='http://www.neoease.com/'>NeoEase</a></p>
</div>
</div>
</div>
</body>
</html>