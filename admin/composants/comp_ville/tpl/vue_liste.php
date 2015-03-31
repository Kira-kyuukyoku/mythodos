<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Liste des villes";

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
			<th>Villes</th>
			<th>Supprimer</th>
		</tr>
	</thead>
	<tbody>


<?php foreach ($liste as $item) : 
			$nb_total 	= intval($item['nb_total']);
			$id 		= intval($item['num_ville']);
			$nom_ville 	= stripslashes(htmlspecialchars( $item['nom_ville'] ));
		   
		//On affiche les infos 
	echo '<tr>';
	echo '<td>#'.$id.'</td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=modifier">'.$nom_ville.'</a></td>';
	echo '<td><a href="index.php?comp='.$comp.'&amp;id='.$id.'&amp;action=supprimer">Supprimer</a></td>';
	echo "</tr>\n";
	  
endforeach;

?>

	</tbody>
</table>
<?php
}

	echo '<p><a href="index.php?comp='.$comp.'&amp;action=modifier" class="btn add">Ajouter</a></p>';
	
	// On calcule le nombre de pages à créer
	$nb_pages	= ceil($nb_total / MAX_ITEM_PAR_PAGE);
	echo pagination('index.php?comp='.$comp, $param='index.php?comp='.$comp.'&amp;page=%d', $page, $nb_pages);

?>