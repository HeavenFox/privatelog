<?php
class Settings
{
	// DB settings
	static $DB = array(
		'driver' => 'mysql',
		'host' => 'localhost',
		'username' => 'root',
		'password' => 'zhujingsi',
		'database' => 'privatelog',
		'prefix' => 'pl_'
	);
	
	// User setting
	static $User = array(
		'username' => 'admin',
		// SHA1-hashed password. d033e22ae348aeb5660fc2140aec35850c4da997 by default - admin being original text
		'password' => 'd033e22ae348aeb5660fc2140aec35850c4da997'
	);
	
	// Security setting
	static $Security = array(
		// Algorithm. aes is sufficient in most cases.
		// NOTE: IF YOUR SERVER DO NOT SUPPORT MCRYPT, SET THIS TO aes AND SET mode TO ecb
		'algorithm' => 'aes',
		// Block cipher algorithm. Leave it alone if you have no idea what it is
		'mode' => 'cbc',
		// Key-Derivation hashing algorithm. sha1 should be sufficient.
		'derivation_hash' => 'sha1',
		// Key-Derivation iteration count. Bigger numbers would be slower, but also decreases the bruteforce attack vulnerability
		// NOTE: DO NOT CHANGE THIS AFTER POSTING OR ENCRYPTED POSTS WOULD NOT BE DECRYPTED
		'derivation_iteration' => 1000
	);
	
	// Site settings
	static $Site = array(
		'name' => 'A Private Log',
		// Entries per page
		'entries' => 2,
		// Use reCAPTCHA when logging in? If so, fill in API keys here
		'recaptcha_public' => '',
		'recaptcha_private' => '',
		// Date/Time Format as php.net
		'dateformat' => 'l, M n, Y g:i:s A'
	);
}
?>