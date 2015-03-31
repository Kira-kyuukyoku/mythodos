<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Circuit '.$nom_cir;
	
?>
<div id="singlerectangle">

<div class="circuittitre"><?php echo $nom_cir; ?></div>
<div id="sejour" class="circuit">	
	<div class="circuitdroite"><a class="colorbox" href="images/villes/<?php echo $img_dep; ?>" title="<?php echo $ville_dep; ?>"><img src="images/villes/mini/<?php echo $img_dep; ?>" alt="<?php echo $ville_dep; ?>" /></a></div>
	<h3>Pays de départ : <?php echo $pays; ?></h3>
	<h3>Durée :  <?php echo $jour_total; ?> <?php echo $nuit_total; ?></h3>
	<h3>Prochain départ : <?php echo $proch_dep; ?></h3>
	<h3>Prix : <?php echo $prix_cir.$devise; ?></h3><br><br>
	

<div id="reserver">
<h10>RESERVER CE SEJOUR</h10>
<form action="index.php?mod=reserver&amp;action=reservation" method="post">


<div class="reservation">
	<div class="h11">1. Complétez le nombre de voyageurs:</div>
	
		<label for="nb_adulte">* Adultes : </label>
			<select name="nb_adulte" size="1">
<?php
				for ($i=1;$i<10;$i++){
					echo '<option value="'.$i.'"';
						if ($i == $nb_adulte){echo ' selected="selected" ';}
					echo '>'.$i.'</option>';
	}
?>
			</select>


		<label for="nb_enfant">* Enfants (2-11 ans) : </label>
			<select name="nb_enfant" size="1">
<?php
				for ($i=0;$i<10;$i++){
					echo '<option value="'.$i.'"';
						if ($i == $nb_enfant){echo ' selected="selected" ';}
					echo '>'.$i.'</option>';
	}
?>
			</select>
			
		<label for="nb_bebe">* Bébés (moins de 2 ans) : </label>
			<select name="nb_bebe" size="1">
<?php
				for ($i=0;$i<5;$i++){
					echo '<option value="'.$i.'"';
						if ($i == $nb_bebe){echo ' selected="selected" ';}
					echo '>'.$i.'</option>';
	}
?>
			</select>

			<br />
</div>
<div class="reservation">

			<div class="h11">2. Choisissez votre séjour en fonction de la date de départ :</div>
<label>* Date de départ</label>
<br />
<?php
	if( !count($liste_date_depart) )
	{
		echo '<p>Aucune date actuellement.</p>';
	}
	else
	{
?>
<select name="prog_cir">
<?php
		foreach ($liste_date_depart as $item) : 
			$prog_cir = intval($item['prog_cir']);
			$date_dep = stripslashes(htmlspecialchars( $item['date_dep'] ));
 //echo $date_dep.' | <a href="index.php?mod='.$mod.'&amp;id='.$id.'&amp;prog='.$prog_cir.'&amp;action=reserver" title="Réserver">Réserver</a> <br />',"\n";
				
			 echo '<option value="'. $prog_cir .'">'.$date_dep.'</option>',"\n";
			
		endforeach;
?>
</select>
<br /><br />

<?php
} // fin else date prog
?>
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Réserver" />
</form>

</div>
</div>

<div class="clear"></div>


	<p><b>Description : </b><?php echo $desc_cir; ?></p>
	
	<b>Ville de départ : </b><?php echo $ville_dep; ?> |  <b>Ville d'arrivée :</b><?php echo $ville_arr; ?><br>
	<a href="#detail"><b>Voir les étapes du séjour</b></a><br />
	<b>Référence circuit à communiquer :</b> <?php echo $id; ?><br />
	<?php echo $liste_img; ?>
</div>	
