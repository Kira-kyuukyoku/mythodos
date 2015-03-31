<?php
if (!empty($_POST) ) // on verifie si les infos sont ok
{

	if ($_POST['cgv'] == 'on') // on verifie que les cgv sont ok
	{
		// extrait nos variables
		extract($_POST);

		if ($civ_cli != 0 && !empty($nom_cli) && !empty($pren_cli) && !empty($ad_cli) && !empty($cp_cli) && !empty($ville_cli) && !empty($pays_cli) && !empty($mail_cli) )
		{
			$prog_cir	= intval($prog_cir);
			$nb_adulte	= intval($nb_adulte);
			$nb_enfant	= intval($nb_enfant);
			$nb_bebe	= intval($nb_bebe);
			$nb_place	= $nb_adulte + $nb_enfant + $nb_bebe;
			$paiement	= intval($paiement);
			
			if ( $paiement == 0 ) {
				$Session->saveForm();
				$Session->setFlash('Vous devez préciser votre mode de réglement.','danger',CURRENT_PAGE.'&action=reservation'); 
				exit;
			}
		
			if ( empty($tel_cli) ) {
				$Session->saveForm();
				$Session->setFlash('Vous devez renseigner un numéro de téléphone.','danger',CURRENT_PAGE.'&action=reservation'); 
				exit;
			}
			if ( !preg_match("#^0[1-68]([-. ]?[0-9]{2}){4}$#", $tel_cli) )
			{
				$Session->saveForm();
				$Session->setFlash('Le numéro de téléphone renseigner n\'a pas un format valide (Format français).','danger',CURRENT_PAGE.'&action=reservation');
				exit;
			}
			if ( !filter_var($mail_cli, FILTER_VALIDATE_EMAIL) ){ // verifie le format de l'email
				$Session->saveForm();
				$Session->setFlash('Cet email a un format non adapté.','danger',CURRENT_PAGE.'&action=reservation');
				exit;
			}
			if ($mail_cli != $emailConfirm) { // verifie si l'email correspond
				$Session->saveForm();
				$Session->setFlash('L\'email ne correspond pas.','danger',CURRENT_PAGE.'&action=reservation');
				exit;
			}
			
			// on passe a la vérification des voyageurs
			foreach($civ_voy as $key=>$value) {
				if($value == 0){
					$Session->saveForm();
					$Session->setFlash('Les civilités des voyageurs doivent être renseigner.','danger',CURRENT_PAGE.'&action=reservation');
					exit;
				}
			}
			
			foreach($nom_voy as $key=>$value) {
				if(!$value){
					$Session->saveForm();
					$Session->setFlash('Tout les nom des voyageurs doivent être renseigner.','danger',CURRENT_PAGE.'&action=reservation');
					exit;
				}
			}
			
			foreach($pren_voy as $key=>$value) {
				if(!$value){
					$Session->saveForm();
					$Session->setFlash('Tout les prénom des voyageurs doivent être renseigner.','danger',CURRENT_PAGE.'&action=reservation');
					exit;
				}
			}
			
			foreach($nais_voy as $key=>$value) {
				if(!$value){
					$dateScind = explode("-", $value);
					$jour 		= (int) $dateScind[0];
					$mois 		= (int) $dateScind[1];
					$annee 		= (int) $dateScind[2];
					$date_sql	= $annee.'-'.$mois.'-'.$jour;
						if ($jour <= 0 && $jour > 31 && $mois <= 0 && $mois > 12 && $annee < 1900 && $annee > date("Y")+1) {
							$Session->saveForm();
							$Session->setFlash('La date de naissance n\'est pas valide.','danger',CURRENT_PAGE.'&action=reservation');
							exit;
						}
					$Session->saveForm();
					$Session->setFlash('Tout les prénom des voyageurs doivent être renseigner.','danger',CURRENT_PAGE.'&action=reservation');
					exit;
				}
			}
			
			foreach($type_voy as $key=>$value) {
				if($value == 0){
					$Session->saveForm();
					$Session->setFlash('Un problème est survenu lors de l\'envoi des données.','danger',CURRENT_PAGE.'&action=reservation');
					exit;
				}
			}
			
			// on insert le client et on recupere son id
			$nom_cli	= $bdd->real_escape_string($nom_cli);
			$pren_cli	= $bdd->real_escape_string($pren_cli);
			$civ_cli 	= intval($civ_cli);
			$ad_cli 	= $bdd->real_escape_string($ad_cli);
			$cp_cli 	= intval($cp_cli);
			$ville_cli 	= $bdd->real_escape_string($ville_cli);
			$pays_cli 	= $bdd->real_escape_string($pays_cli);
			$tel_cli 	= intval($tel_cli);
			$tel2_cli 	= intval($tel2_cli);
			$mail_cli 	= $bdd->real_escape_string($mail_cli);
			
			if(existe_client_reservation($bdd, $nom_cli, $pren_cli, $prog_cir) === true)
			 {
					$Session->setFlash('Il ce peut que vous ayez déjà une réservation à cette même date. Merci de prendre contact avec nous.','danger','index.php');
					exit;
			 }
			 
			$num_cli = add_client($bdd, $nom_cli, $pren_cli, $civ_cli, $ad_cli, $cp_cli, $ville_cli, $pays_cli, $tel_cli, $tel2_cli, $mail_cli);
			
			$num_cli = intval($num_cli);
			
			
			// on insert les voyageurs si le client est bien ajouté
			if($num_cli != 0) {
						$num_res = add_reservation($bdd, $num_cli, $prog_cir, $nb_place);
					
					
					for($i=0; $i<$nb_place; $i++)
					{
						   // On stocke temporairement les données pour cette personne
							$civ_voy	= intval($_POST["civ_voy"][$i]);
							$nom_voy	= $bdd->real_escape_string($_POST["nom_voy"][$i]);
							$pren_voy	= $bdd->real_escape_string($_POST["pren_voy"][$i]);
							$type_voy	= intval($_POST["type_voy"][$i]);
							
							$dateScind 	= explode("-", $_POST["nais_voy"][$i]);
							$jour 		= (int) $dateScind[0];
							$mois 		= (int) $dateScind[1];
							$annee 		= (int) $dateScind[2];
							$nais_voy	= $bdd->real_escape_string($annee.'-'.$mois.'-'.$jour);
							
						   // On insère cette personne dans la base de donnée
							add_voyageur($bdd, $num_cli, $civ_voy, $nom_voy, $pren_voy, $type_voy, $nais_voy);
					}
			}
			
		
				// requête pour le calcul du prix
				$donnees = prix_paiement($bdd, $id, $prog_cir);
				
					$prog_cir 		= intval($donnees['prog_cir']);
					$prix_cir 		= ($donnees['prix_cir'] != 0) ? floatval($donnees['prix_cir']) : 0;
					$devise			= intval($donnees['num_dev']) == 0 ? '€' : '£';
					$devise			= '€';
					$prix_mon 		= ($donnees['prix_mon'] != 0) ? floatval($donnees['prix_mon']) : 0;
					
					// Calcul du montant total
					$prix_par_personne	= $prix_cir + $prix_mon;
					$prix_adulte 		= $nb_adulte * $prix_par_personne;
					$prix_enfant		= $nb_enfant * $prix_par_personne / 2;
					$prix_total			= round($prix_adulte + $prix_enfant, 2).$devise;

					
					if($paiement == 1){
						include(dirname(__FILE__).'/../tpl/form_paiement.php');			
					}
					else {
						// on appel le controller recap puisqu'il n'y a pas de paiement en ligne
						include(dirname(__FILE__).'/recap.php');	
					}

		}
		else {
				// enregistre les données du formulaire dans une session
				$Session->saveForm();
				$Session->setFlash('Veillez remplir tout les champs obligatoires (*).','danger',CURRENT_PAGE.'&action=reservation'); 
		}			
	}
	else {
			// enregistre les données du formulaire dans une session
			$Session->saveForm();
			$Session->setFlash('Vous devez accepter les conditions générales de vente.','danger',CURRENT_PAGE.'&action=reservation');  
	}
}
else {
		// enregistre les données du formulaire dans une session
		$Session->saveForm();
		$Session->setFlash('Un problème est survenu lors de l\'envoi des données11111.','danger',CURRENT_PAGE.'&action=reservation');  
}
?>