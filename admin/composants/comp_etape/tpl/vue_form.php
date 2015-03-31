<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " une étape";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
		<label for="num_eta">* Numéro : </label>
			<select name="num_eta" size="1">';
				<option value="0">- Numéro étape -</option>
<?php
				for ($i=1;$i<10;$i++){
					echo '<option value="'.$i.'"';
						if ($i == $num_eta){echo ' selected="selected" ';}
					echo '>'.$i.'</option>';
	}
?>
			</select><br />
		<br />
		
		<label for="dur_eta">* Durée : </label>
			<select name="dur_eta" size="1">';
				<option value="0">- Durée étape -</option>
<?php
				for ($i=1;$i<10;$i++){
					echo '<option value="'.$i.'"';
						if ($i == $dur_eta){echo ' selected="selected" ';}
					echo '>'.$i.'</option>';
	}
?>
			</select><br />
		<br />
		
		<label for="num_ville">* Ville : </label>
		<select name="num_ville" id="num_ville">
			<option value="0">Selection</option>
<?php	
	if( !count($liste_ville) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
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
						if ( $num_ville == $id_ville ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_ville.'</option>',"\n";
		endforeach;

		}
?>
		</select>
<br /><br />

		<label for="num_cir">* Circuit: </label>
		<select name="num_cir" id="num_cir">
			<option value="0">Selection</option>
<?php	
	if( !count($liste_circuit) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		foreach ($liste_circuit as $item) : 
			$id_cir = intval($item['num_cir']);
			$nom_cir = stripslashes(htmlspecialchars( $item['nom_cir'] ));
				echo '<option value="'.$id_cir.'" ';
		 			if($id_cir != 0) {
						if ( $num_cir == $id_cir ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_cir.'</option>',"\n";
		endforeach;

		}
?>
		</select>
<br /><br />
		<label for="description">* Description: </label>
		<textarea id="description" name="desc_eta" rows="7" cols="50"><?php echo $desc_eta; ?></textarea>
<br /><br />
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
        <input type="hidden" name="old_eta" id="old_eta" value="<?php echo $id; ?>" />
        <input type="hidden" name="old_cir" id="old_cir" value="<?php echo $num_cir; ?>" />
	<input type="submit" value="Envoyer" />
	</form>