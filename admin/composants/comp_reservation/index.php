<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

// inclut les fonctions de requetes SQL
include (dirname(__FILE__).'/modele.php');

//On récupére la valeur de nos variables passé par URL mais on verifie si elle existe avant
if (!empty($_GET['action'])){ $action = htmlspecialchars($_GET['action']);}

	// récupére les infos du formulaire
	$Session->form();

//On regarde la valeur de la variable $action
switch($action)
{
//Si c'est "supprimer"
case "supprimer":
if (isset($id)) { // Si $id existe

	if(isset($_POST['annuler']))
	{
		$Session->setFlash('Suppression annulée.','warning',CURRENT_PAGE); 
    }

		if(isset($_POST['confirmation']) ) {
			$id_delete = $_POST['confirmation'];
			$resultat = supp_reservation($bdd, $id);
				if (!$resultat)
				{
					$Session->setFlash('Une erreur est survenue pendant le traitement de la demande.','danger',CURRENT_PAGE); 
				}
				else
				{
					$Session->setFlash('Item supprimer','danger',CURRENT_PAGE); 
				}
		} else { 
		// On inclus le tpl delete
		include(dirname(__FILE__).'/tpl/vue_delete.php');
		}
	
} else {
		$Session->setFlash('Impossible de supprimer.','danger',CURRENT_PAGE); 
}
break;


case "modifier":
	if (!isset($id)) $id= NULL; 
		//On prend les infos 
		if (!empty($id) || $id > 0) {
	  
			//On récupère les données du pays
			$donnees = voir_reservation($bdd, $id);

			$titre_action = 'Modifier';
			$id = intval($donnees['num_res']);
			$num_cli = stripslashes(htmlspecialchars( $donnees['num_cli'] ));
			$nom_cli = stripslashes(htmlspecialchars( $donnees['nom_cli'] ));
			$pren_cli = stripslashes(htmlspecialchars( $donnees['pren_cli'] ));
			$civ_cli = intval($donnees['civ_cli']) == 1 ? 'Mr' : 'Mme';
			$num_cir = intval($donnees['num_cir']);
			$nom_cir = stripslashes(htmlspecialchars( $donnees['nom_cir'] ));
			$prog_cir = intval($donnees['prog_cir']);
			$date_dep_actuel = stripslashes(htmlspecialchars( $donnees['date_dep'] ));
			$paiement = intval($donnees['paiement']) != 0 ? 'Réglé' : 'Non réglé';
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
				// extrait nos variables
				extract($_POST);
		}
		
		$liste_programme = liste_programme($bdd, $num_cir);
	 
	// On inclus le tpl form
	include(dirname(__FILE__).'/tpl/vue_form.php');

break;


//Si on choisit de modifier
case "verification":
if (!empty($_POST)) // $_POST est une superglobale donc elle existe toujours !
{
	// extrait nos variables
	extract($_POST);
  
	if($prog_cir !=0) // vérifie les champs non remplis
	{
	
			$prog_cir	= intval($prog_cir);

			// On vérifie si c'est une modification ou pas
			if(empty($id) || $id == 0)
			{
				$Session->setFlash('Impossible d\'ajouter un nouvelle élément','danger',CURRENT_PAGE); 
			}
			else
			{
				// C'est une modification, on met juste à jour

				update_reservation($bdd, $id, $prog_cir);
				$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
				$Session->setFlash('Item modifier','success',CURRENT_PAGE);
			}
	}
	else {
		// enregistre les données du formulaire dans une session
		$Session->saveForm();
		$Session->setFlash('Veuillez remplir tous les champs obligatoires (*).','danger',CURRENT_PAGE.'&action=modifier'); 
	}
}
else {
		$Session->setFlash('Un problème est survenu lors de l\'envoi des données.','danger',CURRENT_PAGE); 
	 }
break;
 
default; //Action par defaut: on liste tout
	   
	//On récupère la liste des fiches
	$liste = liste_reservation($bdd);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>