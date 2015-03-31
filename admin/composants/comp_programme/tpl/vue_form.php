<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " une programmation";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification" onSubmit="return verifProgramme(this);">
		
		<label for="date_dep">* Date : </label><input type="date" class="datepicker" name="date_dep" placeholder="jj-mm-aaaa" value="<?php echo $date_dep; ?>" id="date_dep" autofocus required /><br />
		<br />
		<br />
		
		<label for="nb_places">* NB Places : </label><input name="nb_places" id="nb_places" placeholder="Nombre de place" value="<?php echo $nb_places; ?>" required /><br />
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
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>
	
		<div id="resultat"></div>