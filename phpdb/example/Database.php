<?php
namespace Example;
class Database extends \Database\Database {
	static public $dbPath = "../data";
	static public $dbFileName = "example.sqlite";
	/**
	 * Constructor
	 * @param string $dbfile The (sub)path to the database file.
	 */
	function __construct() {
		parent::__construct("example.sqlite");
	}

	function init() {
		$table = $this->addTable(new Messages());
		$table->init();
		return $this;
	}
	static function initClass() {
		self::$dbPath = realpath(dirname(__FILE__).'/'.self::$dbPath);
	}
}
Database::initClass();
