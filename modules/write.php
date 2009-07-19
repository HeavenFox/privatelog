<?php
require_once ROOT.'classes/Post.php';

switch (IO::Inc('do'))
{
case 'post':
	$post = new Post;
	// Check
	if (!IO::Inc('title') || !IO::Inc('content'))
	{
		Template::$Vars['error'] = 'Please complete title and content';
	}
	else
	{
		$params = array();
		$params['id'] = IO::Inc('id');
		$params['title'] = IO::Inc('title');
		$params['content'] = IO::Inc('content');
		$params['time'] = IO::Inc('specifytime') ? mktime(IO::Inc('hour'),IO::Inc('minute'),IO::Inc('second'),IO::Inc('month'),IO::Inc('day'),IO::Inc('year')) : time();
		$params['weather'] = IO::Inc('weather');
		$params['location'] = IO::Inc('location');
		$params['ip'] = IO::GetIP();
		$params['hint'] = IO::Inc('hint');
		$post->fill($params ,false);
		// Get a decrypted copy
		$original = clone $post;
		
		// New
		if (!$params['id'])
		{
			$post->encrypt(IO::Inc('key') ? IO::Inc('key'):Session::Get('password'));
		}
		else
		{
			if (IO::Inc('key'))
			{
				$post->encrypt(IO::Inc('key'));
				Session::Set('postkey-'. IO::Inc('id'),IO::Inc('key'));
			}
			else
			{
				// It should be a special password or the user's password!
				$post->encrypt(Session::Exist('postkey-'. IO::Inc('id')) ? Session::Get('postkey-'. IO::Inc('id')) : Session::Get('password'));
			}
		}
		$pid = $original->id = $post->send();
		
		Template::$Vars['post'] = $original;
		Template::$Vars['message'] = ("Post ".(IO::Inc('id') ? "updated":"saved"));
		
		if ($params['id'])
		{
			$db = Database::Get();
			$db->query("INSERT INTO `pl_adminlog` VALUES (NULL,?,{$pid},?,?)",array('Edited Post',IO::GetIP(),time()));
		}
	}
	break;
// Edit post
case 'edit':
	$post = new Post;
	$post->fetch(IO::Inc('id'));
	
	if (!$post->decrypt(Session::Get('password')) && (!Session::Exist('postkey-'. IO::Inc('id')) || !$post->decrypt(Session::Get('postkey-'. IO::Inc('id')))))
	{
		die('It seems that there is something wrong with the session. Would you mind going back and trying it again?');
	}
	
	Template::$Vars['post'] = $post;
	break;
}
?>