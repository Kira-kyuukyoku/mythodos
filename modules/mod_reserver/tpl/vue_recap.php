<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Récapitulatif de votre commande';
?>
<page backtop="10mm" backbottom="10mm" backleft="20mm" backright="20mm" style="font-size: 14px;font-family: Arial;">
<div id="singlerectangle">

	<h4>Mythodos Travel Agency - Confirmation de votre réservation du <?php echo date('d/m/Y'); ?></h4>

<div class="circuittitre">Détails du circuit</div>
	<div class="circuit">	
	<b>Circuit : </b><?php echo $nom_cir; ?><br />
	<b>Ville de départ : </b><?php echo $ville_dep; ?><br />
	<b>Date de départ : </b><?php echo $proch_dep; ?><br />
	<b>Date de retour : </b><?php echo $date_retour; ?><br />
	<b>Durée : </b><?php echo $jour_total; ?> jours / <?php echo $nuit_total; ?><br />
	<b>Destination: </b><?php echo $pays_depart; ?><br />
	<b>Nbre de personne : </b><?php echo $total_voy; ?><br />
	<b>Voyage: </b><?php echo $prix_cir.$devise; ?> /personne (/2 pour les enfants)<br />
	<b>Monuments : </b><?php echo $prix_mon.$devise; ?><br />


	<p style="text-align: center;"><b>Total : </b><?php echo $prix_total; ?><br /><b><?php echo $paiement; ?></b></p>

	<p>Votre facture : <a href="index.php?page=facture&amp;num_facture=<?=$num_cli?>-r<?=$num_res?>" title="PDF" target="_blank">Télécharger / Ouvrir</a></p>


	<?php
		if($etat_paiement == 0) {
	?>
		<p style="text-align: center;">
		<u>Envoyer votre réglement par chèque à l'adresse suivante :</u><br />
		<b>8 Boulevard Louis XIV, 59000 Lille</b>
		</p>
	<?php } ?>
	</div>


<div class="circuittitre">Vos coordonnées</div>
	<div class="circuit">	
		<b><?php echo $civ_cli.' '.$nom_cli.' '.$pren_cli; ?></b><br />

		<b>E-mail : </b> <?php echo $mail_cli; ?><br />
		
		<b>Téléphone : </b><?php echo $tel_cli; ?><br />
		<?php if(!empty($tel2_cli)) echo 'Téléphone 2 : '. $tel2_cli; ?>
		
		<b>Adresse de livraison : </b><br />
		<?php echo $ad_cli; ?><br />
		<?php echo $cp_cli.' - '.$ville_cli.' - '.$pays_cli; ?><br />
	</div>


<div class="circuittitre">Voyageurs</div>
	<div class="circuit">	
	<?php
		if( !count($liste) )
		{
			echo '<p>Aucun voyageurs ?! </p>';
		}
		   
		//Si $liste retourne 1 on affiche
		else { 
?>

		<ul>

		<?php
			foreach ($liste as $item) : 
				   $civ_voy = (intval($item['civ_voy']) == 1 ) ? 'Mr' : 'Mme';
				   $nom_voy = stripslashes(htmlspecialchars( strtoupper($item['nom_voy']) ));
				   $pren_voy = stripslashes(htmlspecialchars( $item['pren_voy'] ));
				   $num_type_voy = intval($item['type_voy']);
				   
				   if($num_type_voy == 2){
						$type_voy = 'Enfant';
				   }
				   elseif($num_type_voy == 3){
						$type_voy = 'Bébé';
				   }
				   else {
						$type_voy = 'Adulte';
				   }
					$nais_voy	= htmlspecialchars($item['nais_voy']);
						
					$birth = (intval($item['civ_voy']) == 1 ) ? 'Né' : 'Née';
				   
				//On affiche les infos 
		?>

		<li><?php echo $type_voy. ' : ' .$civ_voy. ' ' .$nom_voy.' ' .$pren_voy.' ('.$birth.' le '.$nais_voy.')'; ?></li>

		<?php	  
			endforeach;
			}
		?>
		</ul>
	</div>
</div>
</page>