<?php
function __autoload($class_name) {
	if (substr($class_name, 0, 8) === "Example\\") {
		$class_name = substr($class_name, 8);
	} else {
		$class_name = "../" . $class_name;
	}
//	var_dump($class_name);
	include_once $class_name . '.php';
}

$db = new Example\Database();
$db->init()->create();
