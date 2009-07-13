<?php
/**
 * Private Log
 * A Private Logging Platform for diary or other usage.
 *
 * @author HeavenFox
 * @version v1.0.0
 */
require_once 'init.php';

require_once ROOT. 'settings.php';
require_once ROOT. 'classes/Session.php';
require_once ROOT. 'classes/Cookies.php';
require_once ROOT. 'classes/Template.php';
require_once ROOT. 'classes/crypt/Crypt.php';
require_once ROOT. 'classes/database/Database.php';

session_start();

//------------------------------------------
// DO THE AUTH
//------------------------------------------
$act = $_REQUEST['act'];
if (!Session::Exist('username') || 
	Session::Get('username') != Settings::$User['username'] || 
	sha1(Session::Get('password')) != Settings::$User['password'])
{
	$act = 'login';
}

if (!$act)
{
	$act = 'read';
}

//------------------------------------------
// LOAD MODULE
//------------------------------------------
Template::$Name = $act;
require_once ROOT . 'modules/' . $act . '.php';

//------------------------------------------
// OUTPUT
//------------------------------------------
Template::Out();
?>