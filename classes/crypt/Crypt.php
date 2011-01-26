<?php
/**
 * Versatile
 */
class Crypt
{
	public static function Get($algorithm, $mode)
	{
		if (function_exists('mcrypt_generic_init'))
		{
			// By default mcrypt is used - it's MUCH faster!
			require_once ROOT . 'classes/crypt/methods/Crypt_mcrypt.php';
			return new Crypt_mcrypt($algorithm, $mode);
		}
		else if (($algorithm == 'aes' || $algorithm == 'aes128') && $mode =='ecb')
		{
			// Use PHPAES library, although it's slow
			require_once ROOT . 'classes/crypt/methods/Crypt_PHPAES.php';
			return new Crypt_PHPAES;
		}else
		{
			throw new Exception('No encryption algorithm available');
		}
	}
	
	public static function GenerateSalt($length)
	{
		$hash = sha1(rand(), true);
		$iteration = rand(10,100);
		for ($i=1; $i<=$iteration; $i++)
		{
			$hash ^= (sha1(rand(), true).str_repeat(chr(0),$i));
		}
		return substr($hash,0,$length);
	}
	
	/**
	 * Derive Key using PBKDF2
	 *
	 * @param string $passString String to hash
	 * @param string $salt Salt
	 * @param int $length Desired length
	 * @param 
	 */
	public static function DeriveKey($password, $salt, $length, $iteration, $algorithm)
	{
		if (!function_exists('hash_hmac'))
		{
			function hash_hmac($algo, $data, $key, $raw_output = false)
			{
				$pack = 'H'.strlen($algo('test'));
				$size = 64;
				$opad = str_repeat(chr(0x5C), $size);
				$ipad = str_repeat(chr(0x36), $size);

				if (strlen($key) > $size)
				{
					$key = str_pad(pack($pack, $algo($key)), $size, chr(0x00));
				}
				else
				{
					$key = str_pad($key, $size, chr(0x00));
				}

				for ($i = 0; $i < strlen($key) - 1; $i++) {
					$opad[$i] = $opad[$i] ^ $key[$i];
					$ipad[$i] = $ipad[$i] ^ $key[$i];
				}

				$output = $algo($opad.pack($pack, $algo($ipad.$data)));

				return ($raw_output) ? pack($pack, $output) : $output;
			}
		}


		$start = 0;
		$kb = $start+$length;						// Key blocks to compute 
		$dk = '';									// Derived key 
		
		// Create key 
		for ($block = 1; $block <= $kb; $block++) 
		{ 
			// Initial hash for this block 
			$ib = $h = hash_hmac($algorithm, $salt. pack('N', $block), $password, true); 
			
			// Perform block iterations 
			for ($i=1; $i<$iteration; $i++) 
			{
				// XOR each iterate 
				$ib ^= ($h = hash_hmac($algorithm, $h, $password, true)); 
			}
			
			$dk .= $ib;								// Append iterated block 
		}
		
		// Return derived key of correct length 
		return substr($dk, $start, $length); 
	}
	
}
?>