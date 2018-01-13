<?php
include_once "api.php";
$output = Api::load();
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8"/>
	<script src="js/Database.js"></script>
	<script src="js/Store.js"></script>
	<title>Test indexedDb</title>
</head>
<body>
	<?php echo $output;?>
</body>
</html>
