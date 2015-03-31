<?php
	// extrait nos variables
	extract($_POST);
	
			$prog_cir 			= intval($prog_cir);
			$num_cli 			= intval($num_cli);
			$num_res			= intval($num_res);
			$nb_adulte			= intval($nb_adulte);
			$nb_enfant			= intval($nb_enfant);
			$nb_bebe			= intval($nb_bebe);
			
			// si par chèque, on imagine que le paiement est ok alors on met à jour
			if($paiement == 1){
				update_reservation($bdd, $num_res);
			}

			// requete sql
			$donnees 		= recap_circuit($bdd, $id, $prog_cir, $num_cli);
			
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
				
				$total_voy		= intval($donnees['nb_place']);
				$etat_paiement	= intval($donnees['paiement']);
				$paiement		= ($etat_paiement == 1) ? 'Réglé' : 'Non réglé';
				
				$civ_cli		= (intval($donnees['civ_cli']) == 1) ? 'Mr' : 'Mme';
				$nom_cli		= htmlspecialchars(strtoupper($donnees['nom_cli']));
				$pren_cli		= htmlspecialchars($donnees['pren_cli']);
				$mail_cli		= htmlspecialchars($donnees['mail_cli']);
				$tel_cli		= htmlspecialchars($donnees['tel_cli']);
				$tel2_cli		= htmlspecialchars($donnees['tel2_cli']);
				$ad_cli			= htmlspecialchars($donnees['ad_cli']);
				$cp_cli			= intval($donnees['cp_cli']);
				$ville_cli		= htmlspecialchars($donnees['ville_cli']);
				$pays_cli		= htmlspecialchars($donnees['pays_cli']);
				
			// on récupére les infos des voyageurs
			$liste = liste_voyageur($bdd, $num_cli);
			
			// get the HTML
			ob_start();

			// on appel le template
			include (dirname(__FILE__).'/../tpl/vue_recap.php');
			$content = ob_get_clean();
			
			echo $content;

			// convert to PDF
			require_once(dirname(__FILE__).'/../../../includes/html2pdf.class.php');
			try
			{
				$html2pdf = new HTML2PDF('P', 'A4', 'fr', true, 'UTF-8', 0);
				//$html2pdf->pdf->SetTitle('Récapitulatif de votre commande');
				$html2pdf->writeHTML($content, isset($_GET['vuehtml']));
				$html2pdf->Output(dirname(__FILE__).'/../../../factures/facture-'.$num_cli.'-r'.$num_res.'.pdf', 'F');
				//$html2pdf->Output('c'.$num_cli.'-p'.$prog_cir.'-c'.$id.'.pdf');
			}
			catch(HTML2PDF_exception $e) {
				echo $e;
				exit;
			}

?>