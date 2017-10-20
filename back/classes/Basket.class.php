<?php

class Basket {
	
	private $db = null;
	private $userid = false;
	private $cart = null;
	private $error = array();
	private $found = false;
	private $base = false;
	private $config = array();
	
	
	public function __construct($db, $lang, $user = false) {
		$this->db = $db;
		$this->userid = $user;
		$this->config = $lang;
	}
	
	public function populate() {
		if ($this->userid) {
			$query = $this->db->query("SELECT id, id_item, quantity FROM users_basket WHERE id_user = ?", array($this->userid));
			if ($query->track() > 0) {
				$this->cart = $query->result();
			}
			else $this->error[] = $this->config->get('lang/general/no_items');
		}
		else {
			$this->cart = Cookies::get('basket');
			if (empty($this->cart)) $this->error[] = $this->config->get('lang/general/no_items');
		}
	}
	
	public function add($itemid, $quantity) {
		if ($this->userid) {
			$query = $this->db->single("SELECT quantity FROM users_basket WHERE id_user = ? AND id_item = ?", array($this->userid, $itemid));
			if ($query->track() > 0) {
				// update
				$query = $this->db->query("UPDATE users_basket SET quantity = ? WHERE id_user = ? AND id_item = ?", array($quantity + $query->result(0), $this->userid, $itemid));
				Redirect::go($this->base, 'basket', str_replace('%s%', $itemid, $this->config->get('lang/general/item_added')), 'success');
			}
			else {
				// insert
				$query = $this->db->query("INSERT INTO users_basket VALUES (?, ?, ?, ?)", array(null, $this->userid, $itemid, $quantity));
				Redirect::go($this->base, 'basket', str_replace('%s%', $itemid, $this->config->get('lang/general/item_added')), 'success');
			}
			if ($query->error()) {
				$this->error[] = $this->config->get('lang/general/item_not_added');
			}
		}
		else {
			$this->cart = Cookies::get('basket');
			if (!empty($this->cart)) {
				foreach ($this->cart as &$array) {
					if ($array->id_item == $itemid) {
						$array->quantity = $array->quantity + $quantity;
						$this->found = true;
					}
				}
			}
			if (!$this->found) {
				$this->cart[] = array('id_item' => $itemid, 'quantity' => $quantity);
			}
			Cookies::set('basket', $this->cart);
			Redirect::go($this->base, 'basket', str_replace('%s%', $itemid, $this->config->get('lang/general/item_added')), 'success');
		}
		return $this;
	}
	
	public function merge() {
		$cart = (array) Cookies::get('basket');
		$query = (array) $this->db->query("SELECT id_item, quantity FROM users_basket WHERE id_user = ?", array($this->userid))->result();
		$input = $new = array();

		foreach ($query as $indb) {
			$new[$indb->id_item] = $indb->quantity;
		}
		
		foreach ($cart as $cartsess) {
			if (isset($new[$cartsess->id_item])) $new[$cartsess->id_item] += $cartsess->quantity;
			else $input[$cartsess->id_item] = $cartsess->quantity;
		}
		
		$query = "UPDATE users_basket SET quantity = ? WHERE id_user = ? AND id_item = ?";
		foreach ($new as $id => $value) {
			// update query
			$update = $this->db->query($query, array($value, $this->userid, $id));
		}

		$query = "INSERT INTO users_basket VALUES (?, ?, ?, ?)";
		foreach ($input as $id => $value) {
			// insert query
			$insert = $this->db->query($query, array(null, $this->userid, $id, $value));
		}
		Cookies::del('basket');
		
	}
	
	private function group_by($array, $key, $item) {
		$return = array();
		foreach($array as $val) {
			$return[$val->$key] = (!isset($return[$val->$key])) ? $val->$item : $return[$val->$key] + $val->$item;
		}
		return $return;
	}
	
	public function setbase($base) {
		$this->base = $base;
	}
	
	public function items() {
		return $this->cart;
	}
	
	public function errors() {
		return $this->error;
	}
}