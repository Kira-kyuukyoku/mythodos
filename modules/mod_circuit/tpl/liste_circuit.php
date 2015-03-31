<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Liste des circuits';


	if( !count($liste) )
	{
		echo '<p>Aucun circuit pour ce pays pour le moment.</p>';
	}
	   
	//Si $liste retourne 1 on affiche
	else { 
	
foreach ($liste as $item) : 
			$id 			= intval($item['num_cir']);
			$nom_cir 		= stripslashes(htmlspecialchars( $item['nom_cir'] ));
			
			$purifier 		= new HTMLPurifier();
			$desc_cir 		= $purifier->purify(strip_tags($item['desc_cir']));

			$prix_cir 		= htmlspecialchars($item['prix_cir']);
			$ville_dep 		= htmlspecialchars($item['ville_dep']);
			$nom_ville_etape= htmlspecialchars($item['nom_ville_etape']);
			$ville_etape 	= htmlspecialchars($item['ville_etape']);
			$ville_arr 		= htmlspecialchars($item['ville_arr']);
			$ville_etape 	= htmlspecialchars($item['ville_etape']);
			$jour_total		= intval($item['duree_total']);
			$nuit 			= $jour_total-1;
			$nuit_total 	= ( $nuit > 1 ) ? '/' . $nuit . 'n' : '';
			$proch_dep	 	= htmlspecialchars($item['date_dep']);
			$pays_depart	= htmlspecialchars($item['pays_dep']);
			$pays_arr		= htmlspecialchars($item['pays_arr']);
			//$devise			= intval($item['num_dev']) == 0 ? '€' : '£';
			$devise			= '€';
			
			if($pays_depart == $pays_arr) {
				$pays = $pays_depart;
			} else {
				$pays = $pays_depart . ' - Pays d\'arrivée : ' . $pays_arr;
			}
			
			
			if (strlen($desc_cir) > 150) // si le texte fait plus de 100 caractére, on coupe...
			{
				$desc_cir = substr($desc_cir, 0, 150) . '...';
			}

?>
	<div class="circuittitre"><?php echo $nom_cir; ?></div>
<div class="circuit">

	<div class="circuitdroite"><a class="colorbox" href="images/villes/<?php echo $ville_etape; ?>" title="<?php echo $nom_ville_etape; ?>"><img src="images/villes/mini/<?php echo $ville_etape; ?>" alt="<?php echo $nom_ville_etape; ?>" /></a></div>
	
	<div class="circuitgauche"><b>Pays de départ :</b> <?php echo $pays; ?><br/>
	<b>Durée : </b> <?php echo $jour_total; ?>j <?php echo $nuit_total; ?><br/>
	<b>Description : </b>
	<p id="description"><?php echo $desc_cir; ?></p>
	<b>Prochain départ : </b><?php echo $proch_dep; ?><br/>
	<b>Prix : </b><?php echo $prix_cir.$devise; ?><br />
	<b>Ville de départ : </b><?php echo $ville_dep; ?> |  Ville d'arrivée <?php echo $ville_arr; ?><br />
	<?php echo '<a href="'.$mod.'-'.$id.'-detail.html"><h2>Voir ce séjour</h2></a>'; ?>
	</div>
</div>
	 <div class="clear"></div>
<?php
endforeach;

}
?>


</div> <!-- ferme singlerectangle --> 