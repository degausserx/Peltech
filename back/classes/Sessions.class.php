<?php
class Sessions {
	
	static function check($key) {
		if (isset($_SESSION[$key])) return $_SESSION[$key];
		return false;
	}
	
	static function add($key, $value) {
		$_SESSION[$key] = $value;
	}
	
	static function del($key = array()) {
		if (is_array($key)) {
			foreach ($key as $item => $value) {
				if (isset($_SESSION[$item])) unset($_SESSION[$item]);
			}
		}
		else {
			unset($_SESSION[$key]);
		}
	}
	
}