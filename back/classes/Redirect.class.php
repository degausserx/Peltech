<?php

class Redirect {
	
	static function smooth($base, $page) {
		header("location: " . $base . $page);
		die();
	}
	
	static function go($base, $page, $message, $style = 'primary') {
		Sessions::add('flash_message', $message);
		Sessions::add('flash_style', $style);
		header("location: " . $base . $page);
		die();
	}
	
	static function check() {
		if (Sessions::check('flash_message') && Sessions::check('flash_style')) {
			$return = Display::clist(Sessions::check('flash_style'), array(Sessions::check('flash_message')));
			Sessions::del('flash_message');
			Sessions::del('flash_style');
			return $return;
		}
		return '';
	}

}