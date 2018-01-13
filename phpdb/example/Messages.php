<?php
namespace Example;
use Database\Table;
use Database\Column;
class Messages extends Table {
	public $dbfile;

	/**
	 * Constructor
	 * @param string $dbfile The (sub)path to the database file.
	 */
	function __construct() {
		parent::__construct("messages");
	}

	function init() {
		$col = $this->addColumn(new Column("id", "INTEGER"));
		$col->primary = true;
		$col->autoincrement = true;
		$col = $this->addColumn(new Column("title", "TEXT"));
		$col = $this->addColumn(new Column("message", "TEXT"));
		$col = $this->addColumn(new Column("time", "INTEGER"));
		return $this;
	}
}
