<?php

class User {
	
	private $loggedin = false;
	private $admin = false;
	private $dejafae = false;
	private $basket = false;
	private $mconfig = '';
	private $id = 0;

	public function __construct() {
		if (Sessions::check('user_id') && Hasher::verify(SITESALT, Sessions::check('user_salt'), Sessions::check('user_val'))) {
			if ($this->extracheck()) {
				$this->loggedin = true;
				$this->id = Sessions::check('user_id');
				$query = Db::get()->single(
					"UPDATE users SET date_online = ? WHERE id = ?",
					array(date('Y-m-d H:i:s', time()), $this->id)
				);
				if (Cookies::get('basket')) {
					$this->basket = new Basket(Db::get(), $this->id);
					$this->basket->merge();
				}
				
			}
			else $this->logout();
		}
	}
	
	private function extracheck() {
		$query = Db::get()->single(
			"SELECT id FROM users WHERE id = ? AND salt = ?",
			array(Sessions::check('user_id'), Sessions::check('user_salt'))
		);
		if (!$query->error() && $query->track() == 1) return true;
		return false;
	}

	public function logged() {
		return $this->loggedin;
	}
	
	public function verify($email, $password) {
		$query = Db::get()->single(
			"SELECT id, salt, password FROM users WHERE email = ?",
			array($email)
		);
		if (!$query->error()) {
			$result = $query->result();
			if (Hasher::verify($password, $result['salt'], $result['password'])) {
				Sessions::add('user_id', $result['id']);
				Sessions::add('user_salt', $result['salt']);
				Sessions::add('user_val', Hasher::make(SITESALT, $result['salt']));
				if ($result['admin']) $this->admin = true;
				return true;
			}
		}
		return false;
	}
	
	public function logout($base = 'home', $message = '') {
		$this->loggedin = false;
		Sessions::del('user_val');
		Sessions::del('user_id');
		Sessions::del('user_salt');
		Redirect::go($base, 'home', $message, 'warning');
		die();
	}
	
	public function admin() {
		if (!$this->dejafae && $this->loggedin) {
			$query = Db::get()->single(
				"SELECT admin FROM users WHERE id = ?",
				array(Sessions::check('user_id'))
			);
			if ($query->result()['admin'] == true) {
				$this->admin = true;
			}
			$this->dejafae = true;
		}
		return $this->admin;
	}
	
	public function set_profile() {
		
	}
	
	public function get_profile() {
		$query = Db::get()->single("
			SELECT * FROM users_address WHERE user_id = ?
			", array($this->id)
		);
		if (!$query->error()) {
			return $query->result();
		}
		return array();
	}
}