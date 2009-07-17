<?php
class Settings
{
	// DB settings
	static $DB = array(
		'driver' => 'mysql',
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'heavenfox',
		'database' => 'privatelog',
		'prefix' => 'pl_'
	);
	
	// User setting
	static $User = array(
		'username' => 'HeavenFox',
		// SHA1ed password. d033e22ae348aeb5660fc2140aec35850c4da997 by default - admin being original text
		'password' => 'd033e22ae348aeb5660fc2140aec35850c4da997'
	);
	
	// Security setting
	static $Security = array(
		// Cookie salt. Just some random character. SET IT FOR SECURITY
		'cookie_salt' => 'salt'
	);
	
	// Site settings
	static $Site = array(
		'name' => 'A Private Log',
		// Entries per page
		'entries' => 2
	);
}
?>