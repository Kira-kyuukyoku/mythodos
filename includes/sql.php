<?php
function connexion_DB() {
	// Déclaration des paramètres de connexion
	define('DB_HOST', 'localhost');
	define('DB_LOGIN','root');
	define('DB_PASSWORD','toebo25any');  // vide par defaut
	define('DB_NAME','mythodos');
	
	//$bdd = mysqli_connect('localhost', 'root', '', 'mythodos');
	$bdd = new mysqli(DB_HOST, DB_LOGIN, DB_PASSWORD, DB_NAME);
	/* Vérification de la connexion */
	if (mysqli_connect_errno()) {
		printf("Echec de la connexion : %s\n", mysqli_connect_error());
		exit();
	}

	// Affiche les date sql en français
	$bdd->query("SET lc_time_names = 'fr_FR'"); 
	
	return $bdd;
}
