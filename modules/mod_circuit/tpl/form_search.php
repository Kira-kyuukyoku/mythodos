<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');
?>
<div id="singlerectangle">

<form method="get" action="index.php?mod=<?php echo $mod; ?>">
<div class="formulaire">
		<label for="destination">Votre destination : </label>
		<select name="destination" id="destination">
			<option value="0"> - Selection - </option>
<?php	
	if( !count($liste_pays) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste_pays retourne 1 on affiche
	else { 
		foreach ($liste_pays as $item) : 
			$id_pays = intval($item['num_pays']);
			$nom_pays = stripslashes(htmlspecialchars( $item['nom_pays'] ));
				echo '<option value="'.$id_pays.'" ';
		 			if($id_pays != 0) {
						if ( $destination == $id_pays ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_pays.'</option>',"\n";
		endforeach;

		}
?>
		</select>

		<label for="duree">Durée du séjour : </label>
		<select name="duree" id="duree">
			<option value="0"> - Selection - </option>
			<option value="1" <?php if ( $duree == 1 ){ echo 'selected'; } ?>>Moins de 7 jours</option>
			<option value="2" <?php if ( $duree == 2 ){ echo 'selected'; } ?>>Plus de 7 jours</option>
			<option value="3" <?php if ( $duree == 3 ){ echo 'selected'; } ?>>Plus de 15 jours</option>
		</select>

		<label for="prix_min">Prix minimun : </label>
		<input type="text" name="prix_min" placeholder="Prix minimun" value="" />
</div>
<div class="formulaire">
		<label for="ville_eta">Etape : </label>
		<select name="ville_eta" id="ville_eta">
			<option value="0"> - Selection - </option>
<?php	
	if( !count($liste_ville) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		$pays_en_cours ='';
		foreach ($liste_ville as $item) : 
			$id_ville = intval($item['num_ville']);
			$nom_ville = stripslashes(htmlspecialchars( $item['nom_ville'] ));
			$num_pays = intval($item['num_pays']);
			$nom_pays = htmlspecialchars( $item['nom_pays'] );
			if($pays_en_cours != $num_pays) {  
			$pays_en_cours = $num_pays;
				echo '<optgroup label="'.$nom_pays.' ">'.$nom_pays.'</optgroup>',"\n"; 
				}
				echo '<option value="'.$id_ville.'" ';
		 			if($id_ville != 0) {
						if ( $ville_eta == $id_ville ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_ville.'</option>',"\n";

		endforeach;

		}
?>
		</select>
	
		
		
		<label for="date_dep">Date de départ: </label>
		<select name="date_dep" id="date_dep">
			<option value="0"> - Selection - </option>
<?php	
	if( !count($liste_prog) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		foreach ($liste_prog as $item) : 
			$prog_cir = intval($item['prog_cir']);
			$date_depart = stripslashes(htmlspecialchars( $item['date_dep'] ));
				echo '<option value="'.$prog_cir.'" ';
		 			if($prog_cir != 0) {
						if ( $date_dep == $prog_cir ) 
							{ echo 'selected'; } 
					}
					echo'>'.$date_depart.'</option>',"\n";
		endforeach;

		}
?>
		</select>
		
		<label for="prix_max">Prix maximum : </label>
		<input type="text" name="prix_max" placeholder="Prix maximum" value="" />
		
		<input type="hidden" name="mod" value="<?php echo $mod; ?>" />
		<input type="submit" value="Rechercher" />
		</div>
</form>
<div class="clear"></div>