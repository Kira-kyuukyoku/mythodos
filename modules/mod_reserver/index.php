<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

//On récupére la valeur de nos variables passé par URL mais on verifie si elle existe avant
if (!empty($_GET['action'])){ $action = htmlspecialchars($_GET['action']);}

	// on appel le fichier des requêtes
	include (dirname(__FILE__).'/modele.php');
	
	// récupére les infos du formulaire
	$Session->form();

//On regarde la valeur de la variable $action
switch($action)
{
//Si c'est "reservation"
case "reservation":
	include(dirname(__FILE__).'/controller/reservation.php');
break;


case "paiement":
	include(dirname(__FILE__).'/controller/paiement.php');
break;


case "recap":
	if( $_POST['id'] != 0 && $_POST['prog_cir'] != 0 && $_POST['num_cli'] != 0) // vérifie les champs non remplis
	{ 
		
		include(dirname(__FILE__).'/controller/recap.php');	
				
	}
	else {
			$Session->setFlash('Un problème est survenu lors de l\'envoi des données.','danger',CURRENT_PAGE); 
	}	
break;


default; //Action par defaut: on liste tout
	$Session->setFlash('Un problème est survenu lors de l\'envoi des données.','danger','index.php'); 


} // fin du switch
?>