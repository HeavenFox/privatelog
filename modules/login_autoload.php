<?php
//------------------------------------------
// DO THE AUTH
//------------------------------------------
if (Settings::$Site['recaptcha_private'] && Settings::$Site['recaptcha_public'])
{
	require_once ROOT.'libraries/recaptchalib.php';
}
if (!Session::Exist('username') && !IO::Inc('username', 'POST'))
{
	
	$act = 'login';
}
else
{
	$captcha = true;
	if (IO::Inc('username', 'POST'))
	{
		Session::Set('username', IO::Inc('username', 'POST'));
		Session::Set('password', IO::Inc('password', 'POST'));
		if (Settings::$Site['recaptcha_private'] && Settings::$Site['recaptcha_public'])
		{
			$resp = recaptcha_check_answer(Settings::$Site['recaptcha_private'], $_SERVER["REMOTE_ADDR"], $_POST["recaptcha_challenge_field"], $_POST["recaptcha_response_field"]);
			$captcha = $resp->is_valid;
		}
	}
	
	$success = true;
	
	if (Session::Get('username') != Settings::$User['username'] || sha1(Session::Get('password')) != Settings::$User['password'] || !$captcha)
	{
		$act = 'login';
		Template::$Vars['error'] = 'Invalid Login.';
		session_destroy();
		$success = false;
	}
	// Log login attempt
	if (IO::Inc('username', 'POST'))
	{
		$db = Database::Get();
		$stmt = $db->prepare('INSERT INTO `pl_loginattempt` (`username`,`password`,`success`,`ip`,`time`) VALUES (?,?,?,?,?)');
		$stmt->execute(array(Session::Get('username'),
							sha1(Session::Get('password')) == Settings::$User['password'] ? '***' : Session::Get('password'),
							$success ? 1 : 0,
							IO::GetIP(),
							time()));
	}
}
?>