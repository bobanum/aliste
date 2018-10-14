<?php
include_once "Liste.php";
if (!isset($_GET['id'])) {
	header("location: index.php");
	exit;
}
$element = Element::get($_GET['id']);
if (!$element) {
	header("location: index.php");
	exit;
}
$affichage = $element->html_details();
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="aliste.css"/>
	<title>aListe</title>
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
				<h1>Détails de l'élément</h1>
				<?php echo $element->html_details() ?>
				<?php echo $element->html_options() ?>
			</div>
		</div>
	</div>
</body>
</html>
