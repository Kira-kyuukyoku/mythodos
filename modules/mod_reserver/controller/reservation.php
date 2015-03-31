<?php
if (!empty($_POST)) // $_POST est une superglobale donc elle existe toujours !
{

	// extrait nos variables
	extract($_POST);
  
	if( $nb_adulte != 0 && $prog_cir != 0 && $id != 0) // vérifie les champs non remplis
	{
	
		$nb_adulte 		= intval($nb_adulte);
		$nb_enfant 		= intval($nb_enfant);
		$nb_bebe 		= intval($nb_bebe);
		$prog_cir 		= intval($prog_cir);
		$total_voy		= $nb_adulte + $nb_enfant + $nb_bebe;
		
		$paiement		= (!isset($paiement) ) ? 0 : $paiement;
		
			// requête pour le calcul des places
			$donnees_calcul = circuit_dispo($bdd, $id, $prog_cir);
			
			$place_reserver 		= intval($donnees_calcul['place_reserver']);
			$place_dispo 			= intval($donnees_calcul['place_dispo']);
			$place_restante 		= $place_dispo - $place_reserver;	
		
		if($place_restante >= $total_voy) {
		
			// requete sql
			$donnees 		= recap_circuit($bdd, $id, $prog_cir);
			
				$id 			= intval($donnees['num_cir']);
				$nom_cir 		= stripslashes(htmlspecialchars( $donnees['nom_cir'] ));
				$prix_cir 		= ($donnees['prix_cir'] != 0) ? floatval($donnees['prix_cir']) : 0;
				$ville_dep 		= htmlspecialchars($donnees['ville_dep']);
				$img_dep 		= htmlspecialchars($donnees['img_dep']);
				$ville_arr 		= htmlspecialchars($donnees['ville_arr']);
				$jour_total		= ($donnees['duree_total'] >=1) ? intval($donnees['duree_total']) : 0;
				$nuit_total 	= ($jour_total-1 > 1 ) ? $jour_total-1 . ' nuits' : $jour_total-1 . ' nuit';
				$proch_dep	 	= utf8_encode(ucwords($donnees['date_dep']));
				$date_retour 	= utf8_encode(ucwords((strftime('%A %d %B %Y', strtotime($donnees['date_dep_unix'].'+'.$jour_total.' days')))));
				$pays_depart	= htmlspecialchars($donnees['pays_dep']);
				//$devise			= intval($donnees['num_dev']) == 0 ? '€' : '£';
				$devise			= '€';
				$prix_mon 		= ($donnees['prix_mon'] != 0) ? floatval($donnees['prix_mon']) : 0;
				
				// Calcul du montant total
				$prix_par_personne	= $prix_cir + $prix_mon;
				$prix_adulte 		= $nb_adulte * $prix_par_personne;
				$prix_enfant		= $nb_enfant * $prix_par_personne / 2;
				$prix_total			= round($prix_adulte + $prix_enfant, 2).$devise;
				
				$prog_cir		= intval($donnees['prog_cir']);
				
				$civ_cli		= !empty($civ_cli) ? $civ_cli : 0;
				$nom_cli		= !empty($nom_cli) ? $nom_cli : '';
				$pren_cli		= !empty($pren_cli) ? $pren_cli : '';
				$ad_cli			= !empty($ad_cli) ? $ad_cli : '';
				$cp_cli			= !empty($cp_cli) ? $cp_cli : '';
				$ville_cli		= !empty($ville_cli) ? $ville_cli : '';
				$pays_cli		= !empty($pays_cli) ? $pays_cli : '';
				$tel_cli		= !empty($tel_cli) ? $tel_cli : '';
				$tel2_cli		= !empty($tel2_cli) ? $tel2_cli : '';
				$mail_cli		= !empty($mail_cli) ? $mail_cli : '';
				$emailConfirm	= !empty($emailConfirm) ? $emailConfirm : '';

			// on appel le template
			include (dirname(__FILE__).'/../tpl/form_reservation.php');
		
		}
		else {
			$Session->setFlash('La réservation pour ce circuit n\'est pas possible.','danger','index.php?mod=circuit&id='.$id.'&action=detail'); 
		}
	
	}
	else {
		$Session->setFlash('Vous devez selectionner un programme.','danger','index.php?mod=circuit&id='.$id.'&action=detail'); 
	}
}
else {
		$Session->setFlash('Un problème est survenu lors de l\'envoi des données.','danger',CURRENT_PAGE); 
}
?>