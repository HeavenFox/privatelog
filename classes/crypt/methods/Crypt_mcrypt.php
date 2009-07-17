<?php
class Crypt_mcrypt
{
	public $mc;
	
	public function __construct()
	{
		$this->mc = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
	}
	
	public function encrypt($content, $key)
	{
		mcrypt_generic_init($this->mc, md5($key, true), md5('0', true));
		$cipher = base64_encode(mcrypt_generic($this->mc, $content));
		mcrypt_generic_deinit($this->mc);
		return $cipher;
	}
	
	public function decrypt($cipher, $key)
	{
		mcrypt_generic_init($this->mc, md5($key, true), md5('0', true));
		$content = trim(mdecrypt_generic($this->mc, base64_decode($cipher)),"\0");
		mcrypt_generic_deinit($this->mc);
		return $content;
	}
	
	public function __destruct()
	{
		mcrypt_module_close($this->mc);
	}
}
?>