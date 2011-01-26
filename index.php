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
require_once ROOT. 'classes/IO.php';
require_once ROOT. 'classes/Template.php';
require_once ROOT. 'classes/crypt/Crypt.php';
require_once ROOT. 'classes/database/Database.php';

session_start();

//------------------------------------------
// LOAD MODULE
//------------------------------------------
$act = IO::Inc('act');

$modules = array(
	'login',
	'read',
	'viewlog',
	'write'
);

foreach ($modules as $v)
{
	if (file_exists(ROOT . 'modules/' . $v . '_autoload.php'))
	{
		require ROOT . 'modules/' . $v . '_autoload.php';
	}
}

if (!$act)
{
	$act = 'read';
}

require_once ROOT . 'modules/' . $act . '.php';

Template::$Name = $act;

//------------------------------------------
// OUTPUT
//------------------------------------------
Template::Out();

?>