<?php
namespace Database;
class Table {
	public $name;
	public $db = null;
	public $columns = [];

	function __construct($name) {
		$this->name = $name;
	}
	function create() {
    	$sql = $this->sql_create();
//		var_dump("Creation de la table '{$this->name}'. SQL: {$sql}");
    	$this->db->pdo->exec($sql);
		return $this;
	}
	function addColumn($column) {
//		var_dump("Ajout de la colonne '{$column->name}'.");

		$this->columns[$column->name] = $column;
		$column->table = $this;
		return $column;
	}
	function sql_create() {
		$columns = array_reduce($this->columns, function (&$carry, $item) {
			$carry[] = $item->sql_create();
			return $carry;
		}, []);
		$columns = implode(",", $columns);
		$result = "CREATE TABLE IF NOT EXISTS {$this->name} ($columns)";
		return $result;
	}
}

//    $file_db->exec("CREATE TABLE IF NOT EXISTS messages (
//                    id INTEGER PRIMARY KEY,
//                    title TEXT,
//                    message TEXT,
//                    time INTEGER)");
//
//    // Create table messages with different time format
//    $memory_db->exec("CREATE TABLE messages (
//                      id INTEGER PRIMARY KEY,
//                      title TEXT,
//                      message TEXT,
//                      time TEXT)");
