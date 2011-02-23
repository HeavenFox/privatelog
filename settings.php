<?php
class Settings
{
	// DB settings
	static $DB = array(
		// Database Driver. If your host supports PDO and has enabled its MySQL module, set to pdo_mysql. Otherwise, you can use mysqli
		'driver' => 'mysqli',
		'host' => 'localhost',
		'username' => 'root',
		'password' => '',
		'database' => 'privatelog',
		// deprecated
		'prefix' => 'pl_'
	);
	
	// User setting
	static $User = array(
		'username' => 'admin',
		// SHA1-hashed password. 0925e15d0ae6af196e6295923d76af02b4a3420f by default - admin being original text
		'password' => '0925e15d0ae6af196e6295923d76af02b4a3420f'
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
		'dateformat' => 'l, M j, Y g:i:s A'
	);
}
?>