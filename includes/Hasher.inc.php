<?php

include_once "config.inc.php";

class Hasher {
	
	public static function encrypt( $string ) {
		
		$algorithm = 'rijndael-128';
		$key = md5( ENC_KEY , true);
		$iv_length = mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
		$iv = $key;
		$encrypted = mcrypt_encrypt( $algorithm, $key, $string, MCRYPT_MODE_CBC, $iv );
		$result = base64_encode( $iv . $encrypted );
		return $result;
	}

	public static function decrypt( $string ) {
		$algorithm =  'rijndael-128';
		$key = md5( ENC_KEY, true );
		$iv_length = mcrypt_get_iv_size( $algorithm, MCRYPT_MODE_CBC );
		$string = base64_decode( $string );
		$iv = substr( $string, 0, $iv_length );
		$encrypted = substr( $string, $iv_length );
		$result = mcrypt_decrypt( $algorithm, $key, $encrypted, MCRYPT_MODE_CBC, $iv );
		return $result;
	}

}