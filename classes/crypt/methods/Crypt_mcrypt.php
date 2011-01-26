<?php
class Crypt_mcrypt
{
	public $iv;
	
	private $mc;
	
	private $algorithm;
	private $mode;
	
	public function __construct($_algorithm = 'aes128', $_mode = 'cbc')
	{
		$algorithms = array
			(
			'aes'    => MCRYPT_RIJNDAEL_128,
			'aes128' => MCRYPT_RIJNDAEL_128,
			'aes192' => MCRYPT_RIJNDAEL_192,
			'aes256' => MCRYPT_RIJNDAEL_256
			);
		$modes = array
			(
			'ecb' => MCRYPT_MODE_ECB,
			'cbc' => MCRYPT_MODE_CBC
			);
		$this->algorithm = $algorithms[$_algorithm];
		$this->mode = $modes[$_mode];
		$this->mc = mcrypt_module_open($this->algorithm, '', $this->mode, '');
	}
	
	/**
	 * Generate IV and store it in iv parameter as well as return it
	 * 
	 * @return string IV
	 */
	public function generateIV()
	{
		return $this->iv = mcrypt_create_iv(mcrypt_get_iv_size($this->algorithm, $this->mode), MCRYPT_DEV_RANDOM);
	}
	
	public function ivRequired()
	{
		return $this->mode != 'ecb';
	}
	
	public function encrypt($content, $key, $salt)
	{
		mcrypt_generic_init($this->mc, Crypt::DeriveKey($key, $salt, mcrypt_enc_get_key_size($this->mc), Settings::$Security['derivation_iteration'], 'sha1'), $this->iv);
		$cipher = mcrypt_generic($this->mc, $content);
		mcrypt_generic_deinit($this->mc);
		
		return $cipher;
	}
	
	public function decrypt($cipher, $key, $salt)
	{
		mcrypt_generic_init($this->mc, Crypt::DeriveKey($key,$salt, mcrypt_enc_get_key_size($this->mc), Settings::$Security['derivation_iteration'], 'sha1'), $this->iv);
		$content = trim(mdecrypt_generic($this->mc, $cipher),"\0");
		mcrypt_generic_deinit($this->mc);
		
		return $content;
	}
	
	public function __destruct()
	{
		mcrypt_module_close($this->mc);
	}
}
?>