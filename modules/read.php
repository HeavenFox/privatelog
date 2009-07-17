<?php
require_once ROOT. 'classes/Post.php';
require_once ROOT. 'classes/PostSet.php';

$db = Database::Get();

$condition = array();

$postsHTML = '';
switch (IO::Inc('do'))
{
case 'decrypt':
	// Decrypt certain post, AJAX
	$toDecrypt = new Post();
	$toDecrypt->fetch(IO::Inc('id'));
	$toDecrypt->decrypt(IO::Inc('key'));
	echo $toDecrypt->decryptable ? $toDecrypt->generateContent() : '';
	die();
	break;
// Ajax doesn't seem beautiful
/*
case 'page':
	$set = new PostSet();
	$set->fetch(array('page'=>IO::Inc('page')));
	$set->decrypt(Session::Get('password'));
	die($set->generate());
	break;
*/
default:
	//---------------------------------
	// Parse conditions
	//---------------------------------
	$condition['id'] = IO::Inc('id');
	$condition['page'] = IO::Inc('page');
	$condition['date'] = IO::Inc('date');
	
	
	$set = new PostSet();
	$set->fetch($condition);
	$set->decrypt(Session::Get('password'));
	Template::$Vars['posts'] = $set->generate();
	
	
}

?>