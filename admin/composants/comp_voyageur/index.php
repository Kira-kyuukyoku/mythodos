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
			$resultat = supp_voyageur($bdd, $id);
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
			$donnees = voir_voyageur($bdd, $id);

			$titre_action = 'Modifier';
			$num_cli	= intval($donnees['num_cli']);
			$civ_voy	= intval($donnees['civ_voy']);
			$nom_voy 	= htmlspecialchars($donnees['nom_voy']);
			$pren_voy	= htmlspecialchars($donnees['pren_voy']);
			$type_voy	= intval($donnees['type_voy']);
			$nais_voy	= htmlspecialchars($donnees['nais_voy']);
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
			$num_cli	= 0;
			$civ_voy	= 0;
			$nom_voy 	= NULL;
			$pren_voy	= NULL;
			$type_voy	= NULL;
			$nais_voy	= NULL;
			}
			else {
				// extrait nos variables
				extract($_POST);
			}
		}
	 
	// On inclus le tpl form
	include(dirname(__FILE__).'/tpl/vue_form.php');

break;


//Si on choisit de modifier
case "verification":
if (!empty($_POST)) // $_POST est une superglobale donc elle existe toujours !
{
	// extrait nos variables
	extract($_POST);
  
	if($num_cli !=0 && $civ_voy > 0 && $nom_voy != NULL && $pren_voy != NULL && $type_voy != 0 && $nais_voy != NULL) // vérifie les champs non remplis
	{
	
			$num_cli	= intval($num_cli);
			$civ_voy	= intval($civ_voy);
			$nom_voy	= $bdd->real_escape_string($nom_voy);
			$pren_voy	= $bdd->real_escape_string($pren_voy);
			$type_voy	= intval($type_voy);
			$nais_voy	= $bdd->real_escape_string($nais_voy);
			
			$dateScind = explode("-", $nais_voy);
			$jour 		= $dateScind[0];
			$mois 		= $dateScind[1];
			$annee 		= $dateScind[2];
			$date_sql	= $annee.'-'.$mois.'-'.$jour;


			// On vérifie si c'est une modification ou pas
			if(empty($id) || $id == 0)
			{
				$Session->setFlash('Impossible d\'ajouter un voyageur.','danger',CURRENT_PAGE); 
			}
			else
			{
				// C'est une modification, on met juste à jour
				update_voyageur($bdd, $id, $num_cli, $civ_voy, $nom_voy, $pren_voy, $type_voy, $date_sql);
				
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
	$liste = liste_voyageur($bdd);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>