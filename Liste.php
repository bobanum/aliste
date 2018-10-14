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
		self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS | PDO::FETCH_CLASSTYPE);
		return self::$pdo;
	}
	static function install() {
		$pdo = self::connect();
		Element::install($pdo);
		$element = new Element([
			"titre"=>'Nouvel élément',
			"contenu"=>'Nouveau contenu',
		]);
		$element->save();
		$element = new Element([
			"titre"=>'Autre élément',
			"contenu"=>'Autre contenu',
		]);
		$element->save();
	}
	static function uninstall() {
		@unlink(self::$db_file);
	}
}
