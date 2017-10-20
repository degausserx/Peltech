<?php

class Languages {
	
	static $_languages = array();
	
	static function exists($lang, $reverse = false) {
		if (empty($languages)) {
			if ($result = Db::get()->query("SELECT id, language FROM languages", array())->result()) {
				foreach ($result as $k => $l) {
					self::$_languages[strtoupper($l->language)] = $l->id;
				}
			}
			else self::$_languages = array('FR' => 1, 'NL' => 2, 'EN' => 3);
		}
		if ($reverse) $flip = array_flip(self::$_languages);
		elseif (!isset(self::$_languages[strtoupper($lang)])) { return false; }
		else return self::$_languages[strtoupper($lang)];
		return (isset($flip[$lang])) ? $flip[$lang] : false;
	}
	
	static function llist() {
		$list = array();
		$flip = array_flip(self::$_languages);
		foreach ($flip as $index => $lang) {
			$list[] = strtolower($lang);
		}
		return $list;
	}
}