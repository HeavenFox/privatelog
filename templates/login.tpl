<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="stylesheets/global.css" type="text/css" />
<link rel="stylesheet" href="stylesheets/login.css" type="text/css" /> 
<title>PrivateLog - Login</title>
</head>
<body>
<div id="login">
	<h1>Login</h1>
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
    <form action="index.php" method="post">
    <div id="inputform">
    <p>Username: <input name="username" type="text" size="15" /></p>
    <p>Password: <input name="password" type="password" size="15" /></p>
<?php
if (Settings::$Site['recaptcha_private'] && Settings::$Site['recaptcha_public'])
{
?>
<script type="text/javascript">
var RecaptchaOptions = {
   theme : 'white'
};
</script>
<?php
	echo recaptcha_get_html(Settings::$Site['recaptcha_public']);
}
?>
    </div>
    <input name="submit" type="submit" value="Login" />
    </form>
</div>
</body>
</html>