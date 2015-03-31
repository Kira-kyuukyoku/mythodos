<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Liste des pays du monde";

	if( !count($liste) )
	{
		echo '<p>La table semble etre vide !</p>';
	}
	   
	//Si $liste retourne 1 on affiche
	else { 
?>
	
<table>
	<thead>
		<tr>
			<th>#ID</th>
			<th>Pays</th>
			<th>Supprimer</th>
		</tr>
	</thead>
	<tbody>


<?php foreach ($liste as $item) : 
           $id = intval($item['num_pays']);
           $nom_pays = stripslashes(htmlspecialchars( $item['nom_pays'] ));
           $num_dev = intval($item['num_dev']);
		   
		//On affiche les infos 
	echo '<tr>';
	echo '<td>#'.$id.'</td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=modifier">'.$nom_pays.'</a></td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=supprimer">Supprimer</a></td>';
	echo "</tr>\n";
	  
endforeach;

?>

	</tbody>
</table>
<?php
}

	echo '<p><a class="btn add" href="index.php?comp='.$comp.'&amp;action=modifier">Ajouter</a></p>';

?>