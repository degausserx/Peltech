<?php

Class Datalist {
	
	static function genres() {
		if ($result = Db::get()->query("
			SELECT id, genre FROM items_genre
		", array())->result()) {
			return $result;
		}
		return false;
	}
	
	static function vendor() {
		 if ($result = Db::get()->query("
			SELECT id, name as vendor FROM items_vendor
		", array())->result()) {
			return $result;
		}
		return false;
	}
	
	static function console() {
		 if ($result = Db::get()->query("
			SELECT id, category, console FROM groups_items
		", array())->result()) {
			return $result;
		}
		return false;
	}
	
}