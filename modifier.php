<?php
include_once "Liste.php";
if (isset($_POST['action']) && $_POST['action'] === 'modifier'){
	var_dump($_POST);
	if (isset($_POST['annuler'])) {
		header("location:details.php?id={$element->id}");
		exit;
	}
	$element = Element::traiterModifier($_POST);
	if (!$element) {
		header("location: index.php");
		exit;
	}
	header("location:details.php?id={$element->id}");
	exit;
}

if (!isset($_GET['id'])) {
	header("location: index.php");
	exit;
}
$element = Element::get($_GET['id']);
if (!$element) {
	header("location: index.php");
	exit;
}
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="aliste.css"/>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.7.4/tinymce.min.js"></script>
	<script src="tinymce.init.js"></script>
	<title>Liste des éléments</title>
</head>
<body>
	<div class="interface">
		<header>
			<h1>aListe <small>(au pays des merveilles)</small></h1>
			<nav>
				<ul>
					<li><a href="index.php">Accueil</a></li>
					<li><a href="ajouter.php">Ajouter</a></li>
				</ul>
			</nav>
		</header>
		<footer>&copy;</footer>
		<div class="body">
			<div class="colonne">Colonne</div>
			<div class="contenu">
				<?php echo $element->html_form_modifier(); ?>
			</div>
		</div>
	</div>
</body>
</html>
