<?php
 
class Hasher {
	
	// use password_hash instead
	
	static function salt($string = null) {
		if (!$string) return self::salt(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890"));
		return substr(hash('ripemd160', $string), 0, 20);
	}
     
	static function make($pass = null, $salt = null) {
		if (!$salt || strlen($salt) < 20 || !$pass) return false;
		return password_hash($pass . $salt, PASSWORD_DEFAULT);
	}
	
	static function verify($pass, $salt, $hash) {
		return password_verify($pass . $salt, $hash);
	}

}