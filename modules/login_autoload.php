<?php
//------------------------------------------
// DO THE AUTH
//------------------------------------------
if (!Session::Exist('username'))
{
	$act = 'login';
}

if (IO::Inc('username', 'POST'))
{
	Session::Set('username', IO::Inc('username', 'POST'));
	Session::Set('password', IO::Inc('password', 'POST'));
}

if (Session::Get('username') != Settings::$User['username'] || sha1(Session::Get('password')) != Settings::$User['password'])
{
	$act = 'login';
	Template::$Vars['error'] = 'Invalid username or password.';
}

?>