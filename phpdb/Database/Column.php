<?php
namespace Database;
class Column {
	/** @var Table Reference to parent Table object */
	public $table = null;
	/** @var boolean True if the column is a primary key */
	public $name;
	public $type;
	public $primary = false;
	public $autoincrement = false;

	function __construct($name, $type="TEXT") {
		$this->name = $name;
		$this->type = $type;
	}
	function sql_create() {
		$result = [];
		$result[] = $this->name;
		$result[] = $this->type;
		if ($this->primary) {
			$result[] = 'PRIMARY KEY';
		}
		if ($this->autoincrement) {
			$result[] = 'AUTOINCREMENT';
		}
		$result = implode(" ", $result);
		return $result;
	}
}
