<?php
/**
 * WordPress Importer
 * Based on PrivateLog Generic Importer Framework
 */
//---------------------------------------
// General Options
//---------------------------------------
$table = 'wp_posts';
$key = 'admin';
$useExistingKey = true;

//---------------------------------------
// Advanced Options
//---------------------------------------
// What to add to the query? For example, set it to WHERE `post_status` = 'private' to import private posts only
$condition = '';

//---------------------------------------
// DO NOT EDIT BELOW
//---------------------------------------
$fieldID = 'ID';
$fieldTitle = 'post_title';
$fieldContent = 'post_content';
$fieldKey = 'post_password';
$fieldTime = 'post_date';
$fieldTimeType = 'datetime';
$fieldTimeTimezone = 'Asia/Shanghai';
$fieldWeather = null;
$fieldLocation = null;
$fieldIP = null;

// set timezone
date_default_timezone_set($fieldTimeTimezone);

require_once 'init.php';
require_once ROOT.'settings.php';
require_once ROOT.'classes/Database/Database.php';
require_once ROOT.'classes/Post.php';
require_once ROOT.'classes/Crypt/Crypt.php';

$db = Database::Get();
$db->query("SELECT * FROM `{$table}` {$condition}");

// Post Count
$pc = 0;
$m = $db->fetchAll();
foreach ($m as $r)
{
	$id = $r[$fieldID];
	$p = new Post;
	$p->title = $r[$fieldTitle];
	$p->content = format($r[$fieldContent]);
	
	if ($fieldTimeType == 'datetime')
	{
		$p->time = strtotime($r[$fieldTime]);
	}
	if ($fieldTimeType == 'timestamp')
	{
		$p->time = $r[$fieldTime];
	}
	
	$p->isCipher = false;
	
	// Encrypt
	if ($r[$fieldKey])
	{
		$p->encrypt($r[$fieldKey]);
	}
	else
	{
		$p->encrypt($key);
	}
	$p->send();
	echo 'Imported post #'.$id.' titled '.$r[$fieldTitle].'<br />';
	$pc++;
}
echo 'Well done! '.$pc.' posts are imported.';

function format($text)
{
	return wpautop($text);
}
//----------------------------------------------------
// THE FOLLOWING CODE COMES FROM WORDPRESS
//----------------------------------------------------
function wpautop($pee, $br = 1) {
	if ( trim($pee) === '' )
		return '';
	$pee = $pee . "\n"; // just to make things a little easier, pad the end
	$pee = preg_replace('|<br />\s*<br />|', "\n\n", $pee);
	// Space things out a little
	$allblocks = '(?:table|thead|tfoot|caption|col|colgroup|tbody|tr|td|th|div|dl|dd|dt|ul|ol|li|pre|select|form|map|area|blockquote|address|math|style|input|p|h[1-6]|hr)';
	$pee = preg_replace('!(<' . $allblocks . '[^>]*>)!', "\n$1", $pee);
	$pee = preg_replace('!(</' . $allblocks . '>)!', "$1\n\n", $pee);
	$pee = str_replace(array("\r\n", "\r"), "\n", $pee); // cross-platform newlines
	if ( strpos($pee, '<object') !== false ) {
		$pee = preg_replace('|\s*<param([^>]*)>\s*|', "<param$1>", $pee); // no pee inside object/embed
		$pee = preg_replace('|\s*</embed>\s*|', '</embed>', $pee);
	}
	$pee = preg_replace("/\n\n+/", "\n\n", $pee); // take care of duplicates
	// make paragraphs, including one at the end
	$pees = preg_split('/\n\s*\n/', $pee, -1, PREG_SPLIT_NO_EMPTY);
	$pee = '';
	foreach ( $pees as $tinkle )
		$pee .= '<p>' . trim($tinkle, "\n") . "</p>\n";
	$pee = preg_replace('|<p>\s*</p>|', '', $pee); // under certain strange conditions it could create a P of entirely whitespace
	$pee = preg_replace('!<p>([^<]+)</(div|address|form)>!', "<p>$1</p></$2>", $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee); // don't pee all over a tag
	$pee = preg_replace("|<p>(<li.+?)</p>|", "$1", $pee); // problem with nested lists
	$pee = preg_replace('|<p><blockquote([^>]*)>|i', "<blockquote$1><p>", $pee);
	$pee = str_replace('</blockquote></p>', '</p></blockquote>', $pee);
	$pee = preg_replace('!<p>\s*(</?' . $allblocks . '[^>]*>)!', "$1", $pee);
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*</p>!', "$1", $pee);
	if ($br) {
		$pee = preg_replace_callback('/<(script|style).*?<\/\\1>/s', create_function('$matches', 'return str_replace("\n", "<WPPreserveNewline />", $matches[0]);'), $pee);
		$pee = preg_replace('|(?<!<br />)\s*\n|', "<br />\n", $pee); // optionally make line breaks
		$pee = str_replace('<WPPreserveNewline />', "\n", $pee);
	}
	$pee = preg_replace('!(</?' . $allblocks . '[^>]*>)\s*<br />!', "$1", $pee);
	$pee = preg_replace('!<br />(\s*</?(?:p|li|div|dl|dd|dt|th|pre|td|ul|ol)[^>]*>)!', '$1', $pee);
	if (strpos($pee, '<pre') !== false)
		$pee = preg_replace_callback('!(<pre[^>]*>)(.*?)</pre>!is', 'clean_pre', $pee );
	$pee = preg_replace( "|\n</p>$|", '</p>', $pee );
	$pee = preg_replace('/<p>\s*?(' . get_shortcode_regex() . ')\s*<\/p>/s', '$1', $pee); // don't auto-p wrap shortcodes that stand alone

	return $pee;
}

function get_shortcode_regex() {
	$shortcode_tags = array();
	$tagnames = array_keys($shortcode_tags);
	$tagregexp = join( '|', array_map('preg_quote', $tagnames) );

	return '(.?)\[('.$tagregexp.')\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)';
}
?>