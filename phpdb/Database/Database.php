<?php
namespace Database;
class Database {
	/** @var string The path to the databases for the system */
	static public $dbPath = "databases";
	/** @var PDO The pdo object */
	private $_pdo = null;
	public $tables = [];
	public $dbfile;

	/**
	 * Constructor
	 * @param string $dbfile The (sub)path to the database file.
	 */
	function __construct($dbfile) {
		$this->dbfile = static::$dbPath . '/' . $dbfile;
	}
	function __get($name) {
		$getName = "get" . ucfirst($name);
		$_name = "_" . $name;
		if (method_exists($this, $name)) {
			return $this->$name();
		} elseif (method_exists($this, $getName)) {
			return $this->$getName();
		} elseif (property_exists($this, $_name)) {
			return $this->$_name;
		}
	}
	function __set($name, $value) {
		$setName = "set" . ucfirst($name);
		$_name = "_" . $name;
		if (method_exists($this, $name)) {
			$this->$name($value);
		} elseif (method_exists($this, $setName)) {
			$this->$setName($value);
		} elseif (property_exists($this, $_name)) {
			$this->$_name = $value;
		}
	}

	/**
	 * Getter/setter. Returns the PDO object.
	 * If not connected, creates the PDO
	 * @return PDO The PDO object refering to the datadase
	 */
	function pdo() {
//		var_dump($this->dbfile);
		if (func_num_args() > 0) {
			$this->_pdo = func_get_arg(0);
		}

		if ($this->_pdo) {
			return $this->_pdo;
		}
		$dsn = "sqlite:{$this->dbfile}";
		try {
			$pdo = new \PDO($dsn);
		} catch (PDOException $e) {
			echo 'Unable to connect : ' . $e->getMessage();
		}
		$this->_pdo = $pdo;
		return $this->_pdo;
	}
	function delete() {
		file_put_contents($this->dbfile, "");
		return $this;
	}
	function create() {
//		var_dump("Creation de la base de données.");
		array_walk($this->tables, function (&$table) {
			$table->create();
		});
		return $this;
	}
	function addTable($table) {
//		var_dump($table->name);
		$this->tables[$table->name] = $table;
		$table->db = $this;
		return $table;
	}
}
