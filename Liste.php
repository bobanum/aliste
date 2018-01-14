<?php
include_once "Element.php";
class Liste {
	static $db_file = "liste.sqlite";
	static $pdo = null;
	static function connect() {
		if (self::$pdo) {
			return self::$pdo;
		}
		self::$pdo = new PDO("sqlite:".self::$db_file);
		return self::$pdo;
	}
	static function install() {
		$pdo = self::connect();
		Element::install($pdo);
		$element = new Element([
			"titre"=>'Nouvel élément',
			"contenu"=>'Nouveau contenu',
			"created_at"=>time(),
			"updated_at"=>time(),
		]);
		$element->save();
	}
	static function uninstall() {
		@unlink(self::$db_file);
	}
}
