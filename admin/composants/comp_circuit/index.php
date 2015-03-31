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
			$resultat = supp_circuit($bdd, $id);
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
			$donnees = voir_circuit($bdd, $id);

			 $titre_action = 'Modifier';
			 $nom_cir = htmlspecialchars($donnees['nom_cir']);
			 $desc_cir = htmlspecialchars($donnees['desc_cir']);
			 $prix_cir = floatval($donnees['prix_cir']);
			 $ville_dep = intval($donnees['ville_dep']);
			 $ville_arr = intval($donnees['ville_arr']);
			 
			 $pays_en_cours = 0; 
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
				$nom_cir = NULL;
				$desc_cir = NULL;
				$prix_cir = '';
				$ville_dep = 0;
				$ville_arr = 0;
				
				$pays_en_cours = 0; 
			}
			else {
				// extrait nos variables
				extract($_POST);
			}
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
  
	if($nom_cir != NULL && $desc_cir != NULL && $ville_dep != 0 && $ville_arr != 0 ) // vérifie les champs non remplis
	{
		if( is_numeric($prix_cir) ){
			$nom_cir = $bdd->real_escape_string($nom_cir);
			$prix_cir = floatval($prix_cir);
			$desc_cir = $bdd->real_escape_string($desc_cir);
			$ville_dep = intval($ville_dep);
			$ville_arr = intval($ville_arr);
	
			// On vérifie si c'est une modification ou pas
			if(empty($id) || $id == 0)
			{
				// Vérification si n'éxiste pas déjà
				if(existe_circuit($bdd, $nom_cir) === true)
				 {
					// enregistre les données du formulaire dans une session
					$Session->saveForm();
					$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
				 }
				  else {
					// Ce n'est pas une modification, on crée une nouvelle entrée dans la table
					add_circuit($bdd, $nom_cir, $desc_cir, $prix_cir, $ville_dep, $ville_arr);
					$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
					$Session->setFlash('Item ajouter','success',CURRENT_PAGE); 
					  }
			}
			else
			{		
				// C'est une modification, on met juste à jour
				update_circuit($bdd, $id, $nom_cir, $desc_cir, $prix_cir, $ville_dep, $ville_arr);
				$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
				$Session->setFlash('Item modifier','success',CURRENT_PAGE);
			}
		}
		else {
			// enregistre les données du formulaire dans une session
			$Session->saveForm();
			$Session->setFlash('Le prix doit être indoquer en chiffre.','danger',CURRENT_PAGE.'&action=modifier'); 
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
	$liste = liste_circuit($bdd);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>