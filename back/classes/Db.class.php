<?php
 
class Db {
     
    private static $instance = null;
    private $pdo,
            $track = 0,
            $results,
			$id,
            $error = false;
             
    private function __construct() {
		try {
			$db_config = parse_ini_file('../shop/config/connect.ini', true);
			$this->pdo = new PDO('mysql:host=' . $db_config['database']['host'] . ';port=' . $db_config['database']['port'] . ';dbname=' . $db_config['database']['database'] . ';charset=utf8;',
				$db_config['database']['user'], $db_config['database']['password']);
		} catch (Exception $e) {
			print 'ERROR: Could not connect to DB.';
			die();
		}
    }
     
    public static function get() {
        if (!isset(self::$instance)) self::$instance = new Db();
        return self::$instance;
    }
	 
    public function query($string, $arr, $object = true) {
        $this->error = false;
		$this->results = null;
		$this->track = 0;
        if ($query = $this->pdo->prepare($string)) {
            if ($query->execute($arr)) {
				if ((strpos($string, 'SELECT') !== false)) {
					$this->results = ($object == true) ? $query->fetchAll(PDO::FETCH_OBJ) : $query->fetch();
				}
				$this->id = (strpos($string, 'INSERT') !== false) ? $this->pdo->lastInsertId() : null;
                $this->track = $query->rowCount();
            }
            else {
				$this->error = true;
				$this->track = 0;
			}
        }
        return $this;
    }
	
	public function find($table, $property, $equals, $value, $return, $object = true) {
		$this->error = false;
		$this->track = 0;
		$this->results = null;
		$query = $this->pdo->prepare("SELECT ? FROM ? WHERE ? ? '?'");
		if ($query->execute(array($return, $table, $property, $equals, $value))) {
			$this->results = ($object == true) ? $query->fetchAll(PDO::FETCH_OBJ) : $query->fetch();
			$this->track = $query->rowCount();
		}
		else $this->error = true;
		return $this;
	}
	
	public function sfind($table, $property, $equals, $value, $return) {
		return $this->find($table, $property, $equals, $value, $return, false);
	}
	
	public function single($string, $arr = array()) {
		return $this->query($string, $arr, false);
	}
	
	public function put($table, $property, $value, $where, $match) {
		$this->error = false;
		$this->track = 0;
		$this->results = null;
		$query = $this->pdo->prepare("UPDATE $table SET $property=? WHERE $where = ?");
		if ($query->execute(array($value, $match))) {
			$this->track = $query->rowCount();
		}
		else $this->error = true;
		return $this;
	}
     
    public function error() {
        return $this->error;
    }
     
    public function track() {
        return $this->track;
    }
	
	public function getid() {
        return $this->id;
    }
     
    public function result($n = null) {
        if (!$n && $n !== 0) return $this->results;
        if (isset($this->result()[$n])) return $this->result()[$n];
        return false;
    }
	
	public function close() {
		self::$instance = null;
	}
}