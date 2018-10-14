<?php
include_once "Liste.php";
if (isset($_POST['action']) && $_POST['action'] === 'ajouter'){
	if (isset($_POST['annuler'])) {
		header("location:index.php");
		exit;
	}
	$element = Element::traiterAjouter($_POST);
	if (!$element) {
		header("location: index.php");
		exit;
	} else {
		header("location:details.php?id={$element->id}");
		exit;
	}
}
$affichage = Element::html_form_ajouter();
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<script src="tinymce/tinymce.min.js"></script>
	<script src="tinymce.init.js"></script>
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
				<h1>Ajouter un élément</h1>
				<?php echo $affichage; ?>
			</div>
		</div>
	</div>
</body>
</html>
