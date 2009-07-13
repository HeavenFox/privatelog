<?php
class Session
{
	public static function Set($name, $value)
	{
		$_SESSION[$name] = $value;
	}
	
	public static function Get($name)
	{
		return $_SESSION[$name];
	}
	
	public static function Exist($name)
	{
		return isset($_SESSION[$name]);
	}
	
	public static function Destroy($name)
	{
		unset($_SESSION[$name]);
	}
}
?>