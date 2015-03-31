<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " un monument";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">

		<label for="monument">* Monument : </label><input type="text" name="nom_mon" id="monument" placeholder="Nom" value="<?php echo $nom_mon; ?>" autofocus required /><br />
		<br />
		
		<label for="prix">* Prix : </label><input type="text" name="prix_mon" id="prix" placeholder="Prix" value="<?php echo $prix_mon; ?>" required /><br />
		<br />
		
		<label for="ville">* Villes : </label>
		<select name="num_ville" id="ville">
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
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>