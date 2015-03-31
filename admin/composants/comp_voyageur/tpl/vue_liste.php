<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Liste des voyageurs";

	if( !count($liste) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	   
	//Si $liste retourne 1 on affiche
	else { 
?>
	
<table>
	<thead>
		<tr>
			<th>#ID</th>
			<th>Voyageur</th>
			<th>Modifier</th>
			<!--<th>Supprimer</th>-->
		</tr>
	</thead>
	<tbody>


<?php foreach ($liste as $item) : 
			$id = intval($item['num_voy']);
			$nom_voy = stripslashes(htmlspecialchars( $item['nom_voy'] ));
			$pren_voy = stripslashes(htmlspecialchars( $item['pren_voy'] ));
			$civ_voy = intval($item['civ_voy']) == 1 ? 'Mr' : 'Mme';
		   
		//On affiche les infos 
	echo '<tr>';
	echo '<td>#'.$id.'</td>';
	echo '<td>'.$civ_voy.' ' .$nom_voy.' '.$pren_voy.'</td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=modifier">Modifier</a></td>';
	//echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=supprimer">Supprimer</a></td>';
	echo "</tr>\n";
	  
endforeach;

?>

	</tbody>
</table>
<?php
}

	// echo '<p><a href="index.php?comp='.$comp.'&amp;action=modifier">Ajouter</a></p>';

?>