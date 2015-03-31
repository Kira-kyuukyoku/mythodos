<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	// on appel le fichier des requêtes
	include (dirname(__FILE__).'/modele.php');
	
	// définit $destination par defaut
	$destination = !empty($_GET['destination']) ? intval($_GET['destination']) : 0;
	
	// définit $ville_eta par defaut
	$ville_eta = !empty($_GET['ville_eta']) ? intval($_GET['ville_eta']) : 0;
	
	// définit $duree par defaut
	$duree = !empty($_GET['duree']) ? intval($_GET['duree']) : 0;
	
	// définit $date_dep par defaut
	$date_dep = !empty($_GET['date_dep']) ? intval($_GET['date_dep']) : 0;
	
	// définit le prix par défaut
	// Note : abs() pour empecher les nombres négatif
	$prix_min = !empty($_GET['prix_min']) ? intval(abs($_GET['prix_min'])) : 0; 
	$prix_max = !empty($_GET['prix_max']) ? intval(abs($_GET['prix_max'])) : 0;
	
	// on execute la fonction qui permet d'afficher les bannieres
	$liste_banniere = liste_banniere($bdd);
	
	// Liste les pays
	$liste_pays = liste_pays($bdd);
	
	// Liste les villes
	$liste_ville = liste_ville($bdd);
	
	// Liste des programmes
	$liste_prog = liste_programme($bdd);

	// on appel le template
	include ('tpl/vue.php');

?>