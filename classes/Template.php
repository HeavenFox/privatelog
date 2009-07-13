<?php
class Template
{
	static $Name;
	static $Vars = array();
	
	public static function Out()
	{
		foreach(self::$Vars as $k => $v)
		{
			$$k = $v;
		}
		
		require_once ROOT. 'templates/'. self::$Name. '.tpl';
	}
}
?>