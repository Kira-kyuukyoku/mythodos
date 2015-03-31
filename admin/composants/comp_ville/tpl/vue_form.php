<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " une ville";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
		<label for="ville">* Ville : </label><input type="text" name="nom_ville" id="ville" placeholder="Nom" value="<?php echo $nom_ville; ?>" autofocus required /><br />
		<br />
		
		<label for="pays">* Pays : </label>
		<select name="num_pays" id="pays">
			<option value="0">Selection</option>
<?php	
	if( !count($liste_pays) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		foreach ($liste_pays as $item) : 
			$id_pays = intval($item['num_pays']);
			$nom_pays = stripslashes(htmlspecialchars( $item['nom_pays'] ));
				echo '<option value="'.$id_pays.'" ';
		 			if($id_pays != 0) {
						if ( $num_pays == $id_pays ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_pays.'</option>',"\n";
		endforeach;

		}
?>
		</select>
<br /><br />	

    <fieldset>
        <legend>Image upload</legend>
            <p><input type="file" size="32" name="image_ville" value="" /></p>
			<?php if (!empty($img_ville)){ ?>
			<p>Fichier actuel : <a href="../images/villes/<?php echo $img_ville; ?>" class="colorbox" target="_blank"><?php echo $img_ville; ?></a></p>
			<!--<p><label class="form-inline">Supprimer l'image</label> : <input class="checkbox" type="checkbox" name="del_img" value="Delete" /></p>-->
			<p>  
			<input type="checkbox" id="delete" name="del_img" value="Delete" />  
			<label for="delete">Supprimer l'image</label>  
			</p>  
			<input type="hidden" name="img_hidden" id="img_hidden" value="<?php echo $img_ville; ?>" />
			<?php } ?>
    </fieldset>
		
<br /><br />
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>