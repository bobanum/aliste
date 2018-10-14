<?php
include "Liste.php";
$affichage = Element::html_listeAll();
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="aliste.css"/>
	<title>aListe</title>
</head>
<body>
<?php include "images/icones.svg"; ?>
	<div class="interface">
		<header>
			<h1><small>a</small>Liste <small>(au pays des merveilles)</small></h1>
			<nav>
				<ul>
					<li><a href="index.php">Accueil</a></li>
				</ul>
			</nav>
		</header>
		<footer>&copy;</footer>
		<div class="body">
			<div class="colonne"><div class="pub"><a href="http://tim.cstj.qc.ca/cours/web3"><img src="images/publicite_120x600.svg" width="120" height="600" alt="Une publicité" style="display:block;" /></a></div></div>
			<div class="contenu">
				<h1>Liste des éléments</h1>
				<?php echo $affichage; ?>
				<div>
					<span class="options"><a href="ajouter.php">Ajouter</a></span>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
