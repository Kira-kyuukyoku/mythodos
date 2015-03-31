<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

// inclut les fonctions de requetes SQL
include (dirname(__FILE__).'/modele.php');

//On récupére la valeur de nos variables passé par URL mais on verifie si elle existe avant
if (!empty($_GET['action'])){ $action = htmlspecialchars($_GET['action']);}
if (!empty($_GET['circuit'])){ $num_cir = intval($_GET['circuit']);}

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
			$resultat = supp_circuit($bdd, $id, $num_cir);
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
	  
			//On récupère les données
			$donnees = voir_etape($bdd, $id, $num_cir);

			 $titre_action = 'Modifier';
			 $num_eta 	= intval($donnees['num_eta']);
			 $desc_eta 	= htmlspecialchars($donnees['desc_eta']);
			 $dur_eta 	= intval($donnees['dur_eta']);
			 $num_ville = intval($donnees['num_ville']);
			 $num_cir 	= intval($donnees['num_cir']);
			 $old_eta 	= $num_eta;
			 $old_cir 	= $num_cir;
			 
			 $pays_en_cours = 0; 
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
				$num_eta 	= 0;
				$desc_eta 	= NULL;
				$dur_eta 	= 0;
				$num_ville 	= 0;
				$num_cir 	= 0;
				$old_eta 	= 0;
				$old_cir 	= 0;
				
				$pays_en_cours = 0; 
			}
			else {
				// extrait nos variables
				extract($_POST);
			}
		}
		
	$liste_ville = liste_ville($bdd);
	
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
  
	if($num_eta != 0 && $desc_eta != NULL && $dur_eta != 0 && $num_ville != 0 && $num_cir != 0 ) // vérifie les champs non remplis
	{
			$num_eta 	= intval($num_eta);
			$desc_eta 	= $bdd->real_escape_string($desc_eta);
			$dur_eta 	= intval($dur_eta);
			$num_ville 	= intval($num_ville);
			$num_cir 	= intval($num_cir);
			$old_eta 	= intval($old_eta);
			$old_cir 	= intval($old_cir);
	
			// On vérifie si c'est une modification ou pas
			if(empty($id) || $id == 0)
			{
				// Vérification si n'éxiste pas déjà
				if(existe_etape($bdd, $num_eta, $num_cir) === true)
				 {
					// enregistre les données du formulaire dans une session
					$Session->saveForm();
					$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
				 }
				  else {
					// Ce n'est pas une modification, on crée une nouvelle entrée dans la table
					add_etape($bdd, $num_eta, $desc_eta, $dur_eta, $num_ville, $num_cir);
					$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
					$Session->setFlash('Item ajouter','success',CURRENT_PAGE); 
					  }
			}
			else
			{		
				// Vérification si n'éxiste pas déjà
				if($num_eta == $old_eta && $num_cir == $old_cir)
				 {
					// C'est une modification, on met juste à jour
					update_etape($bdd, $num_eta, $desc_eta, $dur_eta, $num_ville, $num_cir, $old_eta, $old_cir);
					$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
					$Session->setFlash('Item modifier','success',CURRENT_PAGE);
				 }
				if (existe_etape($bdd, $num_eta, $num_cir) === false) {
					update_etape($bdd, $num_eta, $desc_eta, $dur_eta, $num_ville, $num_cir, $old_eta, $old_cir);
					$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
					$Session->setFlash('Item modifier','success',CURRENT_PAGE);
					  }
				else {
					$Session->saveForm();
					$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
				}
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
	   
	//On récupère la liste par rapport à la page courante
	$liste = liste_etape($bdd, $page);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>