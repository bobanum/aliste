<?php
include_once "Liste.php";
Liste::uninstall();
Liste::install();
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<title>Liste des éléments</title>
</head>
<body>
	<div class="interface">
		<header>
			<h1>Liste des éléments</h1>
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
			<div class="contenu">Contenu</div>
		</div>
	</div>
</body>
</html>
