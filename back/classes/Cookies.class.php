<?php

Class Cookies {
	
	static function get($cookie) {
		return (isset($_COOKIE[$cookie])) ? json_decode($_COOKIE[$cookie]) : false;
	}
	
	static function set($cookie, $data) {
		setcookie($cookie, json_encode($data), time() + (86400 * 30), "/"); // 86400 = 1 day
	}
	
	static function del($cookie) {
		unset($_COOKIE[$cookie]);
		setcookie($cookie, '', time() - 3600, "/");
	}
	
}