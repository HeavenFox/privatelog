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
		'password' => '' // SHA1ed
	);
	
	// Security setting
	static $Security = array(
		// Cookie salt. Just some random character. SET IT FOR SECURITY
		'cookie_salt' => ''
	);
	
	// Site settings
	static $Site = array(
		'name' => 'A Private Log',
		// Entries per page
		'entries' => 3
	);
}
?>