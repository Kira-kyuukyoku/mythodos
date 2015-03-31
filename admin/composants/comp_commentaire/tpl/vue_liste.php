<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Liste des commentaires";

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
			<th>Pseudo</th>
			<th>Date</th>
			<th>Circuit</th>
			<th>Modifier</th>
			<th>Supprimer</th>
		</tr>
	</thead>
	<tbody>


<?php foreach ($liste as $item) : 
           $id = intval($item['num_com']);
           $pseudo_com = stripslashes(htmlspecialchars( $item['pseudo_com'] ));
           $date_com = stripslashes(htmlspecialchars( $item['date_com'] ));
           $nom_cir = stripslashes(htmlspecialchars( $item['nom_cir'] ));
		   
		//On affiche les infos 
	echo '<tr>';
	echo '<td>#'.$id.'</td>';
	echo '<td>'.$pseudo_com.'</td>';
	echo '<td>'.$date_com.'</td>';
	echo '<td>'.$nom_cir.'</td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=modifier">Modifier</a></td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=supprimer">Supprimer</a></td>';
	echo "</tr>\n";
	  
endforeach;

?>

	</tbody>
</table>
<?php
}

?>