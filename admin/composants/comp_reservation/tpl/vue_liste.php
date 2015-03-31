<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Liste des réservations";

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
			<th>Circuit</th>
			<th>Date de départ</th>
			<th>Client</th>
			<th>Paiement</th>
			<th>Modifier</th>
			<th>Supprimer</th>
		</tr>
	</thead>
	<tbody>


<?php foreach ($liste as $item) : 
			$id = intval($item['num_res']);
			$nom_cli = stripslashes(htmlspecialchars( $item['nom_cli'] ));
			$pren_cli = stripslashes(htmlspecialchars( $item['pren_cli'] ));
			$civ_cli = intval($item['civ_cli']) == 1 ? 'Mr' : 'Mme';
			$nom_cir = stripslashes(htmlspecialchars( $item['nom_cir'] ));
			$date_dep = stripslashes(htmlspecialchars( $item['date_dep'] ));
			$paiement = intval($item['paiement']) != 0 ? 'Réglé' : 'En attente';
		   
		//On affiche les infos 
	echo '<tr>';
	echo '<td>#'.$id.'</td>';
	echo '<td>'.$nom_cir.'</td>';
	echo '<td>'.$date_dep.'</td>';
	echo '<td>'.$civ_cli.' ' .$nom_cli.' '.$pren_cli.'</td>';
	echo '<td>'.$paiement.'</td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=modifier">Modifier</a></td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=supprimer">Supprimer</a></td>';
	echo "</tr>\n";
	  
endforeach;

?>

	</tbody>
</table>
<?php
}

	// echo '<p><a href="index.php?comp='.$comp.'&amp;action=modifier">Ajouter</a></p>';

?>