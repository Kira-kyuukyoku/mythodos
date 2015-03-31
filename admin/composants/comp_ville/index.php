<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

// inclut les fonctions de requetes SQL
include (dirname(__FILE__).'/modele.php');

// notre class upload
include(dirname(__FILE__).'/../../../includes/upload/upload.class.php');

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
			$resultat = supp_ville($bdd, $id);
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
			$donnees = voir_ville($bdd, $id);

			 $titre_action = 'Modifier';
			 $nom_ville = htmlspecialchars($donnees['nom_ville']);
			 $img_ville = htmlspecialchars($donnees['img_ville']);
			 $num_pays = intval($donnees['num_pays']);
		}
		else 
		{ 
			// récupére les infos du formulaire si c'est un renvois
			$Session->form();
	
			$titre_action = 'Ajouter';
			 
			if(empty($_POST)){
				$nom_ville = NULL;
				$img_ville = '';
				$num_pays = 0;
			}
			else {
				// extrait nos variables
				extract($_POST);
			}
		}
		
	$liste_pays = liste_pays($bdd);
	
	// On inclus le tpl form
	include(dirname(__FILE__).'/tpl/vue_form.php');

break;


//Si on choisit de modifier
case "verification":
if (!empty($_POST)) // $_POST est une superglobale donc elle existe toujours !
{
	// extrait nos variables
	extract($_POST);
  
	if($nom_ville != NULL && $num_pays != 0) // vérifie les champs non remplis
	{
    $nom_ville = $bdd->real_escape_string($nom_ville);
	$num_pays = intval($num_pays);
	$nom_fichier = (!empty($img_hidden)) ? $bdd->real_escape_string($img_hidden) : '';
	
	// dossier d'upload
	$dir_upload = '../images/villes/';

    // Upload Image	
	if(!empty($_FILES['image_ville']['type'])) {
	
    // on récupére la valeur de l'image via le form
    $handle = new Upload($_FILES['image_ville'], 'fr_FR');

    // vérifie si le fichier a bien était uploader correctement (dossier /tmp)
    if ($handle->uploaded) {

        // si fichier bien sur le serveur, on resize
        $handle->image_resize            = true;
        $handle->image_ratio_y           = true;
        $handle->image_x                 = 500;

        // Redirection de l'image dans le dossier cible
		// on change le nom, et on écrase au besoin
		$handle->file_new_name_body = strtolower($nom_ville);
		$handle->file_new_name_ext = 'jpg';
		$handle->file_overwrite = true;
        $handle->Process($dir_upload);

        // on recommence avec d'autre paramétres
        $handle->image_resize            = true;
        $handle->image_ratio_y           = true;
        $handle->image_x                 = 220;

        // Création de l'image: On la redirige dans le répertoire .mini
		// on change le nom, et on écrase au besoin
		$handle->file_new_name_body = strtolower($nom_ville);
		$handle->file_new_name_ext = 'jpg';
		$handle->file_overwrite = true;
        $handle->Process($dir_upload."mini/");
		
		$nom_fichier = $bdd->real_escape_string($handle->file_dst_name);

        // on vérifie si OK
        if (!$handle->processed) {
            // il y a une erreur
		$Session->saveForm();
		$Session->setFlash($handle->error,'warning',CURRENT_PAGE.'&id='.$id.'&action=modifier');
        }

        // suppression des fichiers temporaires
        $handle-> Clean();

    } else {
        // le serveur n'a pas reçus notre image !
		$Session->saveForm();
		$Session->setFlash($handle->error,'warning',CURRENT_PAGE.'&id='.$id.'&action=modifier');
    }
	
	}
	
		// On vérifie si c'est une modification ou pas
		if(empty($id) || $id == 0)
		{
				// Vérification si n'éxiste pas déjà
			// Vérification si n'éxiste pas déjà
			if(existe_ville($bdd, $nom_ville) === true)
			 {
			 	// enregistre les données du formulaire dans une session
				$Session->saveForm();
				$Session->setFlash('Un item avec le même nom existe déjà !','warning',CURRENT_PAGE.'&action=modifier'); 
			 }
			  else {
				// Ce n'est pas une modification, on crée une nouvelle entrée dans la table
				add_ville($bdd, $nom_ville, $nom_fichier, $num_pays);
				$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
				$Session->setFlash('Item ajouter','success',CURRENT_PAGE); 
				  }
		}
		else
		{
			// C'est une modification, on met juste à jour
			//si on choisis de supprimer l'image
			if (!empty($del_img))
			{
				update_ville($bdd, $id, $nom_ville, '', $num_pays);
				unlink($dir_upload.strtolower($nom_ville).'.jpg');
				unlink($dir_upload.'mini/'.strtolower($nom_ville).'.jpg');
			}
			else {
				update_ville($bdd, $id, $nom_ville, $nom_fichier, $num_pays);
			}
			$Session->detroyForm(); // detruit $_SESSION['sauvegarde'] si existe
			//$Session->setFlash('Item modifier','success',CURRENT_PAGE);
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
	   
	// On récupère la liste par rapport à la page courante
	$liste = liste_ville($bdd, $page);

	// On inclus le tpl liste
	include(dirname(__FILE__).'/tpl/vue_liste.php');
 
} // Fin du switch
?>