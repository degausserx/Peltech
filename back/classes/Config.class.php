<?php

class Config {
	
	// defaults
	private $config = array();
	
	public function __construct($arr = array()) {
		$this->config = $arr;
		$this->config['pages'] = array(
			'home' => true,
			'register' => 'guest',
			'logout' => 'user',
			'login' => 'guest',
			'password_recover' => 'guest',
			'about' => true,
			'shop' => true,
			'profile' => 'user',
			'history' => 'user',
			'basket' => true,
			'checkout' => 'user',
			'admin' => 'admin'
		);
		$this->config['pages_nav'] = array(
			'register' => true,
			'logout' => true,
			'login' => true,
			'password_recover' => true,
			'about' => true,
			'profile' => true,
			'history' => true,
			'checkout' => true,
			'admin' => true
		);
	}
	
	// return value
	public function get($string = null) {
		if (!Input::isempty($string)) {
			$e = explode('/', $string);
			$config = $this->config;
			foreach ($e as $s) {
				if (isset($config[$s])) $config = $config[$s];
				else return false;
			}
			return $config;
		}
		return false;
	}
	
	public function getc($string = null) {
		return $this->get(Input::clean($string));
	}
	
	// insert value
	public function put($arr = array()) {
		if (count($arr) > 0) {
			foreach ($arr as $block => $value) {
				$e = explode('/', $block);
				$config = &$this->config;
				$fkey = array_pop($e);
				foreach ($e as $b) {
					if ($b) $config = &$config[$b];
				}
				$config[$fkey] = $value;
			}
		}
	}
	
	// insert array
	public function add($cell, $arr) {
		$this->config[$cell] = $arr;
	}
	
}