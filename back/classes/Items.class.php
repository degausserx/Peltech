<?php

class Items {
	
	private $db = null;
	private $lang = null;
	private $items = array();
	private $all = false;
	private $sortby = 'rating';
	private $orderby = 'DESC';

	public function __construct($db, $lang, $item_id = -1, $all = false) {
		$this->db = $db;
		$this->lang = $lang;
		if ($all) { $this->all = true; }
		if (in_array(Input::get('orderby'), array('asc', 'desc'))) $this->orderby = strtoupper(Input::get('orderby'));
		if (in_array(Input::get('sortby'), array('rating', 'price', 'timestamp'))) $this->sortby = Input::get('sortby');
		if ($item_id > 0) { $this->populate_category($item_id, $lang); }
		elseif ($item_id == 0) { $this->populate_category_all($lang); }
		else { $this->populate_slider($lang); }
	}

	private function populate_category($item_id, $lang) {
		if ($result = $this->db->query("
			SELECT a.id as id, a.stock, a.image, a.rating, a.price, a.timestamp, b.name as brand, c.title as title, c.description as description, d.category as category
			FROM items a, items_vendor b, items_text c, groups_items d
			WHERE a.id_group = ? AND a.id_vendor = b.id AND c.id_item = a.id AND c.id_language = ? AND a.id_group = d.id
			ORDER BY a.$this->sortby $this->orderby
		", array($item_id, Languages::exists($lang)))->result()) {
			$this->items = $result;
		}
	}
	
	private function populate_category_all($lang) {
		$limit = ($this->all == false) ? 'LIMIT 10' : '';
		$query = "
			SELECT a.id as id, a.stock, a.image, a.price, a.timestamp, a.rating, b.name as brand, c.title as title, c.description as description, d.category as category, e.genre
			FROM items a, items_vendor b, items_text c, groups_items d, items_genre e
			WHERE a.id_vendor = b.id AND a.id = c.id_item AND c.id_language = ? AND a.id_group = d.id AND a.id_genre = e.id
			ORDER BY a.$this->sortby $this->orderby
		" . " " . $limit;
		if ($result = $this->db->query($query, array(Languages::exists($lang)))->result()) {
			$this->items = $result;
		}
	}
	
	private function populate_slider($lang) {
		if ($result = $this->db->query("
			SELECT a.id as id, a.stock, a.image_large, a.price, a.timestamp, b.name as brand, c.title as title, d.category as category
			FROM items a, items_vendor b, items_text c, groups_items d
			WHERE a.image_large != '' AND a.id_vendor = b.id AND c.id_item = a.id AND c.id_language = ? AND a.id_group = d.id
		", array(Languages::exists($lang)))->result()) {
			$this->items = $result;
		}
	}
	
	public function items($n = -1) {
		if ($n > -1 && isset($this->items[$n])) return $this->items[$n];
		elseif (is_array($this->items)) return $this->items;
		return null;
	}

	public function reload($n = 0) {
		if ($n == 0) $this->populate_slider($this->lang);
		else $this->populate_category($n, $this->lang);
	}
	
	public function rating($rating) {
		$string = '';
		if (!$rating) return 'Not rated';
		for ($x = 50; $x < 500; $x += 100) {
			if ($x < $rating) $string .= '<span class="glyphicon glyphicon-star"></span>';
			else $string .= '<span class="glyphicon glyphicon-star-empty"></span>';
		}
		return $string;
	}
}