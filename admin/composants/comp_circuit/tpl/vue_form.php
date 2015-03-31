<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " un circuit";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">

		<label for="nom_circuit">* Nom : </label><input type="text" name="nom_cir" id="nom_circuit" placeholder="Nom" value="<?php echo $nom_cir; ?>"  autofocus required /><br />
		<br />
		
		<label for="prix_cir">* Prix : </label><input type="text" name="prix_cir" id="prix_cir" placeholder="Prix" value="<?php echo $prix_cir; ?>" required /><br />
		<br />
		
		<label for="ville_dep">* Villes de départ: </label>
		<select name="ville_dep" id="ville_dep">
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
						if ( $ville_dep == $id_ville ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_ville.'</option>',"\n";

		endforeach;

		}
?>
		</select>
<br /><br />

		<label for="ville_arr">* Villes d'arrivée: </label>
		<select name="ville_arr" id="ville_arr">
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
						if ( $ville_arr == $id_ville ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_ville.'</option>',"\n";
		endforeach;

		}
?>
		</select>
<br /><br />
		<label for="description">* Description: </label>
		<textarea id="description" name="desc_cir" rows="7" cols="50"><?php echo $desc_cir; ?></textarea>
<br /><br />
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>