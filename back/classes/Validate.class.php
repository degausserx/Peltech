<?php
 
class Validate {
     
	private $error = array();
	private $results = array();
	private $verdict = false;
	private $db = null;
	private $config = null;

	public function __construct($db, $config) {
		$this->db = $db;
		$this->config = $config;
	}

	public function set($arr = array()) {
		if (Input::exists()) {
			foreach ($arr as $key => $value) {
				$this->results[$key] = $data = trim(Input::get($key));
				if (isset($value['reference'])) $field = $value['reference'];
				if (isset($value['search'])) $column = $value['search'];
				if (isset($value['required']) && $value['required'] && Input::isempty($data)) $this->eset($field, $key, 'no_empty');
				elseif (Input::isempty($data)) continue;
				else {
					foreach ($value as $k => $v) {
						switch($k) {
							case 'strmin':
								if (strlen($data) < $v) $this->eset($field, $key, $k, $v);
							break;
							case 'strmax':
								if (strlen($data) > $v) $this->eset($field, $key, $k, $v);
							break;
							case 'max':
								if ($data > $v) $this->eset($field, $key, $k, $v);
							break;
							case 'min':
								if ($data < $v) $this->eset($field, $key, $k, $v);
							break;
							case 'equals':
								if ($data !== trim(Input::get($v))) $this->eset($field, $key, $k, $v);
							break;
							case 'integer':
								if (!ctype_digit($data)) $this->eset($field, $key, $k, $v);
							break;
							case 'decimal':
								if (!preg_match('/^\d+\.\d+$/',$data) && !ctype_digit($data)) $this->eset($field, $key, $k, $v);
							break;
							case 'unique':
								if ($this->db->single("SELECT $key FROM $v WHERE $key = ?", array($data))->track() > 0) $this->eset($field, $key, $k, $v);
							break;
							case 'email':
								if ($data != filter_var($data, FILTER_SANITIZE_EMAIL)) $this->eset($field, $key, $k, $v);
							break;
							case 'exists':
								if ($this->db->single("SELECT $column FROM $v WHERE $column = ?", array($data))->error()) $this->eset($field, $key, $k, $v);
							break;
							case 'image':
								if (!in_array(substr($data, -4), array('.jpg', '.gif', '.bmp', '.png'))) $this->eset($field, $key, 'image_extension', $v);
								if (file_exists($v)) $this->eset($field, $key, 'image_exists', $v);
							break;
							case 'object':
								if ($v['name'] !== substr($arr[$key]['image'], -1 * strlen($v['name']))) $this->eset($field, $key, 'image_mismatch');
								if (substr($v['type'], 0, 6) !== 'image/') $this->eset($field, $key, 'image_mime');
							break;
						}
					}
				}
			}
			if (empty($this->error)) $this->verdict = true;
		}
		return $this;
	}
	
	private function merge($arr, $string) {
		return str_replace(array('%s%', '%n%'), $arr, $string);
		return $string;
	}
	
	private function eset($field, $key, $error, $value = '') {
		$this->error[] = $this->merge(array($field, $value), $this->config->get('lang/errors/' . $error));
		$this->results[$key] = false;
	}
	 
	public function errors() { return $this->error; }
	 
	public function pass() { return $this->verdict; }
	
	public function error_list() {
		print Display::clist('danger', $this->error);
	}
	
	public function get($field) {
		return (isset($this->results[$field])) ? $this->results[$field] : false;
	}
}