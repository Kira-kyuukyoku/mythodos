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
			$resultat = supp_monument($bdd, $id);
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
			$donnees = voir_monument($bdd, $id);

			 $titre_action = 'Modifier';
			 $nom_mon = htmlspecialchars($donnees['nom_mon']);
			 $prix_mon = floatval($donnees['prix_mon']);
			 $num_ville = intval($donnees['num_ville']);
			
			 $pays_en_cours = 0; 
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
				$nom_mon = NULL;
				$prix_mon = '';
				$num_ville = 0;
			}
			else {
				// extrait nos variables
				extract($_POST);
			}
			$pays_en_cours = 0; 
		}
		
	$liste_ville = liste_ville($bdd);
	
	// On inclus le tpl form
	include(dirname(__FILE__).'/tpl/vue_form.php');

break;


//Si on choisit de modifier
case "verification":
if (!empty($_POST)) // $_POST est une superglobale donc elle existe toujours !
{
	// extrait nos variables
	extract($_POST);
  
	if($nom_mon != NULL && $num_ville != 0 ) // vérifie les champs non remplis
	{
		if( is_numeric($prix_mon) ){
			$nom_mon = $bdd->real_escape_string($nom_mon);
			$num_ville = intval($num_ville);
			$prix_mon = floatval($prix_mon);
	
			// On vérifie si c'est une modification ou pas
			if(empty($id) || $id == 0)
			{
				// Vérification si n'éxiste pas déjà
				if(existe_monument($bdd, $nom_mon) === true)
				 {
					// enregistre les données du formulaire dans une session
					$Session->saveForm();
					$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
				 }
				  else {
					// Ce n'est pas une modification, on crée une nouvelle entrée dans la table
					add_monument($bdd, $nom_mon, $prix_mon, $num_ville);
					//$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
					$Session->setFlash('Item ajouter','success',CURRENT_PAGE); 
					  }
			}
			else
			{		
				// C'est une modification, on met juste à jour
				update_monument($bdd, $id, $nom_mon, $prix_mon, $num_ville);
				//$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
				$Session->setFlash('Item modifier','success',CURRENT_PAGE);
			}
		}
		else {
			// enregistre les données du formulaire dans une session
			$Session->saveForm();
			$Session->setFlash('Le prix doit être indiquer en chiffre.','danger',CURRENT_PAGE.'&action=modifier'); 
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
	$liste = liste_monument($bdd);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>