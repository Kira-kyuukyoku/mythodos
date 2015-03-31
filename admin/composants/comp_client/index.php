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
			$resultat = supp_client($bdd, $id);
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
			$donnees = voir_client($bdd, $id);

			$titre_action = 'Modifier';
			$nom_cli 	= htmlspecialchars($donnees['nom_cli']);
			$pren_cli	= htmlspecialchars($donnees['pren_cli']);
			$civ_cli	= intval($donnees['civ_cli']);
			$ad_cli		= htmlspecialchars($donnees['ad_cli']);
			$cp_cli		= htmlspecialchars($donnees['cp_cli']);
			$ville_cli	= htmlspecialchars($donnees['ville_cli']);
			$pays_cli	= htmlspecialchars($donnees['pays_cli']);
			$tel_cli	= htmlspecialchars($donnees['tel_cli']);
			$tel2_cli	= htmlspecialchars($donnees['tel2_cli']);
			$mail_cli	= htmlspecialchars($donnees['mail_cli']);
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
				$nom_cli 	= NULL;
				$pren_cli	= NULL;
				$civ_cli	= 0;
				$ad_cli		= NULL;
				$cp_cli		= NULL;
				$ville_cli	= NULL;
				$pays_cli	= NULL;
				$tel_cli	= NULL;
				$tel2_cli	= NULL;
				$mail_cli	= NULL;
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
  
	if($nom_cli != NULL && $pren_cli != NULL && $civ_cli > 0 && $ad_cli != NULL && $cp_cli != NULL && $ville_cli != NULL && $pays_cli != NULL && $mail_cli != NULL) // vérifie les champs non remplis
	{
	
		if($tel_cli != NULL || $tel2_cli != NULL) { // si au moins un des 2 numéro de téléphone est remplis
	
			$nom_cli	= $bdd->real_escape_string($nom_cli);
			$pren_cli	= $bdd->real_escape_string($pren_cli);
			$civ_cli	= intval($civ_cli);
			$ad_cli		= $bdd->real_escape_string($ad_cli);
			$cp_cli		= $bdd->real_escape_string($cp_cli);
			$ville_cli	= $bdd->real_escape_string($ville_cli);
			$pays_cli	= $bdd->real_escape_string($pays_cli);
			$tel_cli	= $bdd->real_escape_string($tel_cli);
			$tel2_cli	= $bdd->real_escape_string($tel2_cli);
			$mail_cli	= $bdd->real_escape_string($mail_cli);

			// On vérifie si c'est une modification ou pas
			if(empty($id) || $id == 0)
			{
				// Vérification si n'éxiste pas déjà
				if(existe_client($bdd, $nom_cli, $pren_cli) === true)
				 {
					// enregistre les données du formulaire dans une session
					$Session->saveForm();
					$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
				 }
				  else {
					// Ce n'est pas une modification, on crée une nouvelle entrée dans la table
					add_client($bdd, $nom_cli, $pren_cli, $civ_cli, $ad_cli, $cp_cli, $ville_cli, $pays_cli, $tel_cli, $tel2_cli, $mail_cli);
					$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
					$Session->setFlash('Item ajouter','success',CURRENT_PAGE); 
					  }
			}
			else
			{
				// C'est une modification, on met juste à jour
				update_client($bdd, $id, $nom_cli, $pren_cli, $civ_cli, $ad_cli, $cp_cli, $ville_cli, $pays_cli, $tel_cli, $tel2_cli, $mail_cli);
				$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
				$Session->setFlash('Item modifier','success',CURRENT_PAGE);
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
	   
	//On récupère la liste des fiches
	$liste = liste_client($bdd);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>