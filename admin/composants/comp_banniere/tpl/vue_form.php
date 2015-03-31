<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " une bannière";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
		<label for="banniere">* Nom Bannière : </label><input type="text" name="nom_ban" id="banniere" placeholder="Nom" value="<?php echo $nom_ban; ?>" autofocus required /><br />
		<br />
		
		<label for="circuit">* Circuit : </label>
		<select name="num_cir" id="circuit">
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
		<textarea id="description" name="desc_ban" rows="7" cols="50"><?php echo $desc_ban; ?></textarea>
<br /><br />	

    <fieldset>
        <legend>Image upload</legend>
            <p><input type="file" size="32" name="image_banniere" value="" /></p>
			<?php if (!empty($img_ban)){ ?>
			<p>Fichier actuel : <a href="../images/bannieres/<?php echo $img_ban; ?>" class="colorbox" target="_blank"><?php echo $img_ban; ?></a></p>
			<!--<p><label><input class="checkbox" type="checkbox" name="del_img" value="Delete" /> Supprimer l'image</label></p>-->
			<p>  
			<input type="checkbox" id="delete" name="del_img" value="Delete" />  
			<label for="delete">Supprimer l'image</label>  
			</p>  
			<input type="hidden" name="img_hidden" id="img_hidden" value="<?php echo $img_ban; ?>" />
			<?php } ?>
    </fieldset>
		
<br /><br />
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>