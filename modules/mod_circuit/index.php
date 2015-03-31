<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

//On récupére la valeur de nos variables passé par URL mais on verifie si elle existe avant
if (!empty($_GET['action'])){ $action = htmlspecialchars($_GET['action']);}

	// on appel le fichier des requêtes
	include (dirname(__FILE__).'/modele.php');
	
//On regarde la valeur de la variable $action
switch($action)
{
//Si c'est "voir le detail"
case "detail":

	// On récupère les infos
	$donnees 			= voir_circuit($bdd, $id);
	$liste_date_depart 	= liste_date_depart($bdd, $id);
	$liste_etape		= liste_etape($bdd, $id);
	$liste_comment		= liste_comment($bdd, $id);
		
			$id 			= intval($donnees['num_cir']);
			$nom_cir 		= stripslashes(htmlspecialchars( $donnees['nom_cir'] ));
	
			$purifier 		= new HTMLPurifier();
			$desc_cir 		= $purifier->purify($donnees['desc_cir']);
			
			$prix_cir 		= htmlspecialchars($donnees['prix_cir']);
			$ville_dep 		= htmlspecialchars($donnees['ville_dep']);
			$img_dep 		= htmlspecialchars($donnees['img_dep']);
			$img_ville		= explode(",", htmlspecialchars($donnees['img_ville']));
			$ville_arr 		= htmlspecialchars($donnees['ville_arr']);
			$jour_total		= ( intval($donnees['duree_total']) > 1 ) ? intval($donnees['duree_total']) . ' jours' : intval($donnees['duree_total']) . ' jour'; 
			$nuit 			= $jour_total-1;
			$nuit_total 	= ( $nuit > 1 ) ? '/ ' . $nuit . ' nuits' : '/ ' . $nuit . ' nuit';
			$proch_dep	 	= htmlspecialchars($donnees['date_dep']);
			$pays_depart	= htmlspecialchars($donnees['pays_dep']);
			$pays_arr		= htmlspecialchars($donnees['pays_arr']);
			//$devise			= intval($donnees['num_dev']) == 0 ? '€' : '£';
			$devise			= '€';
			
			$liste_img = '';
			foreach($img_ville as $img )
			{
				 if ( !empty($img) ){
					$image = 'images/villes/'.$img;
					$min_image = 'images/villes/mini/'.$img;
					$nom_img = ucfirst(substr($img, 0, strpos($img, '.'))); 
						$liste_img .= '<a class="colorbox" href="'.$image.'" title="'.$nom_img.'"><img class="circuit_img" src="'.$min_image.'" alt="'.$nom_img.'" /></a>';
				 } 
			}
			
			if($pays_depart == $pays_arr) {
				$pays = $pays_depart;
			} else {
				$pays = $pays_depart . ' - Pays d\'arrivée : ' . $pays_arr;
			}
			
			$nb_adulte 	= 1;
			$nb_enfant 	= 0;
			$nb_bebe 	= 0;

	// on appel les templates
	include (dirname(__FILE__).'/tpl/voir_circuit.php');
	include (dirname(__FILE__).'/tpl/voir_etape.php');
	include (dirname(__FILE__).'/tpl/voir_comment.php');
	
break;


case "postComment":

	// fonction captcha
	require_once('includes/captcha/php-captcha.inc.php');

	// Declare mon url de redirection
	$num_cir = intval($_POST['num_cir']); 
	define('CURRENT_PAGE_COMMENT', $_SERVER['PHP_SELF'].$current_page.'&id='.$num_cir.'&action=detail', true);

if (!empty($_POST))
{
	if (!empty($_POST['pseudo_com']) && !empty($_POST['mess_com']) && !empty($_POST['num_cir']) && !empty($_POST['captcha'])) {
	
		if (PhpCaptcha::Validate($_POST['captcha']) )
		{
				$pseudo_com = $bdd->real_escape_string($_POST['pseudo_com']);
				$mess_com	= $bdd->real_escape_string($_POST['mess_com']);

					// insertion dans la bdd
					add_comment($bdd, $pseudo_com, $mess_com, $num_cir);
					$Session->setFlash('Commentaire ajouté !','success',CURRENT_PAGE_COMMENT);
		}
		else {
				$Session->setFlash('Le code ne correspond pas !','danger',CURRENT_PAGE_COMMENT); 
			}
	}
	else {
			$Session->setFlash('Un moins un champs est vide !','danger',CURRENT_PAGE_COMMENT); 
	}
}
else {
		$Session->setFlash('Un problème est survenu lors de l\'envoi des données.','danger',CURRENT_PAGE_COMMENT); 
}

break;


default; //Action par defaut: on liste tout

	// définit $destination par defaut
	$destination = !empty($_GET['destination']) ? intval($_GET['destination']) : 0;
	
	// définit $ville_eta par defaut
	$ville_eta = !empty($_GET['ville_eta']) ? intval($_GET['ville_eta']) : 0;
	
	// définit $duree par defaut
	$duree = !empty($_GET['duree']) ? intval($_GET['duree']) : 0;
	
	// définit $date_dep par defaut
	$date_dep = !empty($_GET['date_dep']) ? intval($_GET['date_dep']) : 0;
	
	// définit le prix par défaut
	// Note : abs() pour empecher les nombres négatif
	$prix_min = !empty($_GET['prix_min']) ? intval(abs($_GET['prix_min'])) : 0; 
	$prix_max = !empty($_GET['prix_max']) ? intval(abs($_GET['prix_max'])) : 0;

	// On récupère la liste
	$liste = liste_circuit($bdd, $destination, $ville_eta, $duree, $date_dep, $prix_min, $prix_max);
	
	// Liste les pays
	$liste_pays = liste_pays($bdd);
	
	// Liste les ville
	$liste_ville = liste_ville($bdd);
	
	// Liste des programmes
	$liste_prog = liste_programme($bdd);

	// on appel le template
	include (dirname(__FILE__).'/tpl/form_search.php');	
	
	include (dirname(__FILE__).'/tpl/liste_circuit.php');


} // fin du switch

?>