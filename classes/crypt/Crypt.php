<?php
/**
 * Algorithm: 128-bit AES, ECB Mode
 */
class Crypt
{
    public static function Get()
	{
		if (function_exists('mcrypt_generic_init'))
		{
			// By default mcrypt is used - it's MUCH faster!
			require_once ROOT . 'classes/crypt/methods/Crypt_mcrypt.php';
			return new Crypt_mcrypt;
		}
		else
		{
			// Use PHPAES library, although it's slow
			require_once ROOT . 'classes/crypt/methods/Crypt_PHPAES.php';
			return new Crypt_PHPAES;
		}
	}
}
?>