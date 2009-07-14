<?php
class IO
{
	public static function Inc($key, $through = 'all')
	{
		$r = null;
		$source = null;
		
		switch ($through)
		{
		case 'all':
			$source = &$_REQUEST;
			break;
		case 'GET':
			$source = &$_GET;
			break;
		case 'POST':
			$source = &$_POST;
		}
		
		
		if ( isset($source[$key]) )
		{
			$r = $source[$key];
		}
		else
		{
			return false;
		}
		
		// I do NOT think 'magic quotes' is magic - thank god it's removed
		if (get_magic_quotes_gpc())
		{
			return stripslashes($r);
		}
		return $r;
	}
	
	public static function GetIP()
	{
		return $_SERVER['REMOTE_ADDR'];
	}
}
?>