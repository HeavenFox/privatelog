<?php
require ROOT . 'classes/crypt/methods/lib/AES.class.php';

class Crypt_PHPAES
{
	public function encrypt($content, $key)
	{
		$obj = new AES(md5($key,true));
		return base64_encode($obj->encrypt($content));
	}
	
	public function decrypt($cipher, $key)
	{
		$obj = new AES(md5($key,true));
		return $obj->decrypt(base64_decode($cipher));
	}
}
?>