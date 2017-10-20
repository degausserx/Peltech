<?php

class Display {
	
	static $tabindex = 1;
	
	static function clist($style, $list = array()) {
		$string = '';
		if (!empty($list)) {
			$string = '<div class="alert alert-' . Input::clean($style) . '"><a class="close" data-dismiss="alert" href="#">×</a>';
			foreach ($list as $l) {
				$string .= Input::clean($l) . '<br />';
			}
			$string .= '</div>';
		}
		return $string;
	}

	static function tab() {
		return self::$tabindex++;
	}
	
}