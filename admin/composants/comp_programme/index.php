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
			$resultat = supp_programme($bdd, $id);
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
	if (!isset($id)) $id = NULL; 
		//On prend les infos 
		if (!empty($id) || $id > 0) {
	  
			//On récupère les données du pays
			$donnees = voir_programme($bdd, $id);

			 $titre_action = 'Modifier';
			 $date_dep	= htmlspecialchars($donnees['date_dep']);
			 $nb_places	= intval($donnees['nb_places']);
			 $num_cir 	= intval($donnees['num_cir']);
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
				$date_dep	= NULL;
				$nb_places	= '';
				$num_cir	= 0;
			}
			else {
				// extrait nos variables
				extract($_POST);
			}
		}
	 
	$liste_circuit = liste_circuit($bdd);	 
	 
	// On inclus le tpl form
	include(dirname(__FILE__).'/tpl/vue_form.php');

break;


//Si on choisit de modifier
case "verification":
if (!empty($_POST)) // $_POST est une superglobale donc elle existe toujours !
{
	// extrait nos variables
	extract($_POST);
  
	if($nb_places != 0 && $date_dep !=NULL && $num_cir != 0) // vérifie les champs non remplis
	{
	$date_dep = $bdd->real_escape_string($date_dep);
	$nb_places = intval($nb_places);
	$num_cir = intval($num_cir);
	
	$dateScind = explode("-", $date_dep);
	$jour 		= $dateScind[0];
	$mois 		= $dateScind[1];
	$annee 		= $dateScind[2];
	$date_sql	= $annee.'-'.$mois.'-'.$jour;

	
		// On vérifie si c'est une modification ou pas
		if(empty($id) || $id == 0)
		{
				// Vérification si n'éxiste pas déjà
			// Vérification si n'éxiste pas déjà
			if(existe_programme($bdd, $prog_cir) === true)
			 {
			 	// enregistre les données du formulaire dans une session
				$Session->saveForm();
				$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
			 }
			  else {
				// Ce n'est pas une modification, on crée une nouvelle entrée dans la table
				add_programme($bdd, $date_sql, $nb_places, $num_cir);
				$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
				$Session->setFlash('Item ajouter','success',CURRENT_PAGE); 
				  }
		}
		else
		{
			// C'est une modification, on met juste à jour
			update_programme($bdd, $id, $date_sql, $nb_places, $num_cir);
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
	   
	//On récupère la liste
	$liste = liste_programme($bdd);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>