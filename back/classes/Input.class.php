<?php
 
class Input {
     
	static function exists($method = 'post') {
		if ($method == 'post') return (!empty($_POST)) ? '$_POST' : false;
		if ($method == 'get') return (!empty($_GET)) ? '$_GET' : false;
		if ($method == 'files') return (!empty($_FILES)) ? '$_FILES' : false;
		return false;
	}

	static function clean($string) { return htmlentities($string, ENT_QUOTES, 'UTF-8'); }
	static function isempty($string = null) { return (strlen($string) < 1) ? true : false; }

	static function get($prop, $prop2 = null) {
		if (!$prop2) {
			if (isset($_POST[$prop])) return $_POST[$prop];
			elseif (isset($_GET[$prop])) return $_GET[$prop];
			elseif (isset($_FILES[$prop])) return $_FILES[$prop];
			return '';
		}
		else {
			if (isset($_POST[$prop][$prop2])) return $_POST[$prop][$prop2];
			elseif (isset($_GET[$prop][$prop2])) return $_GET[$prop][$prop2];
			elseif (isset($_FILES[$prop][$prop2])) return $_FILES[$prop][$prop2];
			return '';
		}
	}
	
	static function getc($prop) { return self::clean(self::get($prop)); }
}