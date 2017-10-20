<?php

class Product {
	
	private $db = null;
	private $lang = null;
	private $id = null;
	private $exists = false;
	private $data = null;
	private $datatext = null;
	
	public function __construct($db, $lang, $itemid, $full = false) {
		$this->db = $db;
		$this->lang = $lang;
		$this->id = $itemid;
		if (!$full) $this->populate();
		else $this->populate_full();
		return $this;
	}
	
	private function populate() {
		if ($result = $this->db->single("
			SELECT a.id, a.stock, a.image, a.price, a.rating, a.timestamp, b.name as vendor, c.title, c.description
			FROM items a, items_vendor b, items_text c
			WHERE a.id = ? AND a.id_vendor = b.id AND a.id = c.id_item AND c.id_language = ?
		", array($this->id, Languages::exists($this->lang)))->result()) {
			$this->data = $result;
			$this->exists = true;
		}
	}
	
	private function populate_full() {
		if ($result = $this->db->single("
			SELECT a.id, a.stock, a.price, a.id_vendor, a.id_group, a.id_genre
			FROM items a
			WHERE a.id = ?
		", array($this->id))->result()) {
			$this->data = $result;
			$result = null;
			$result = $this->db->query("
				SELECT id_language, title, description
				FROM items_text
				WHERE id_item = ?
			", array($this->data['id']))->result();
			$this->datatext = $result;
			$this->exists = true;
		}
	}
	
	public function exists() {
		return ($this->exists) ? true : false;
	}
	
	public function get() {
		return $this->data;
	}
	
	public function getext() {
		return $this->datatext;
	}
}