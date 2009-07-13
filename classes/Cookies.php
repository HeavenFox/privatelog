<?php
class Cookies
{
	/**
	 * Get a cookie
	 */
	public static function Get($name)
	{
		$crypt = Crypt::Get();
		
		return $crypt->decrypt($_COOKIE[$name], Settings::$Security['cookie_salt']);
	}
	
	/**
	 * Set a cookie
	 */
	public static function Set($name, $value, $expire)
	{
		$crypt = Crypt::Get();
		
		setcookie($name, $crypt->encrypt($value, Settings::$Security['cookie_salt'], time() + $expire);
	}
}
?>