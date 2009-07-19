<?php
//------------------------------------------
// DO THE AUTH
//------------------------------------------
if (!Session::Exist('username') && !IO::Inc('username', 'POST'))
{
	$act = 'login';
}
else
{
	if (IO::Inc('username', 'POST'))
	{
		Session::Set('username', IO::Inc('username', 'POST'));
		Session::Set('password', IO::Inc('password', 'POST'));
	}
	
	if (Session::Get('username') != Settings::$User['username'] || sha1(Session::Get('password')) != Settings::$User['password'])
	{
		$act = 'login';
		Template::$Vars['error'] = 'Invalid username or password.';
		session_destroy();
		// Wrong login attempt or invalid cookie
		$db = Database::Get();
		$db->query('INSERT INTO `pl_loginattempt` VALUES (NULL,?,?,?,?)', array(Session::Get('username'),
																				Session::Get('password'),
																				IO::GetIP(),
																				time()));
	}
}
?>