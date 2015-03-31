<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " une réservation";
?>
	<form method="post" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
	Client : <?php echo $civ_cli . ' ' . $nom_cli . ' ' . $pren_cli; ?><br />
	Circuit : <?php echo $nom_cir; ?><br />
	Paiement : <?php echo $paiement; ?><br />
	
	Date de départ actuelle : <?php echo $date_dep_actuel; ?><br /><br />
	
	<label for="programme">* Choisir une nouvelle date de départ : </label>
		<select name="prog_cir" id="programme">
			<option value="0"> - Selection - </option>
<?php
	if( !count($liste_programme) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		foreach ($liste_programme as $item) : 
			$id_prog = intval($item['prog_cir']);
			$date_dep = stripslashes(htmlspecialchars( $item['date_dep'] ));
				echo '<option value="'.$id_prog.'"';
		 			if($id_prog != 0) {
						if ( $prog_cir == $id_prog ) 
							{ echo 'selected'; } 
					}
					echo'>'.$date_dep.'</option>',"\n";
		endforeach;

		}
?>
		</select>
<br /><br />
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="num_cli" id="num_cli" value="<?php echo $num_cli; ?>" />
	<input type="submit" value="Envoyer" />
	</form>