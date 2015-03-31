<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Accueil';
?>
<!--CAROUSSEL--> 
<div id="wrapper">
			<div id="slider">

<?php foreach ($liste_banniere as $item) : 
			$id 			= intval($item['num_ban']);
			$nom_ban 		= stripslashes(htmlspecialchars( $item['nom_ban'] ));
			
			$purifier 		= new HTMLPurifier();
			$desc_ban 		= $purifier->purify($item['desc_ban']);
			
			$img_ban 		= htmlspecialchars($item['img_ban']);
			$num_cir 		= intval($item['num_cir']);
			
			if (strlen($desc_ban) > 250) // si le texte fait plus de 100 caractére, on coupe...
			{
				$desc_ban = substr($desc_ban, 0, 250) . '...';
			}
?>
		<div class="slide" style="background-image: url(images/bannieres/<?php echo $img_ban; ?>);">
			<div class="slide-block"><a href="<?php echo 'index.php?mod=circuit&amp;id='.$num_cir.'&amp;action=detail'; ?>">
				<h1><?php echo $nom_ban; ?></h1>
				<p><b><?php echo $desc_ban; ?></b></p></a>
			</div>
		</div>
	  
<?php
endforeach;
?>
	</div>
</div>

<!--3 COLONNES-->
<span id="featstyle">


		<!--TITRES-->
    	<div id="featuredheader1">
        <img src="images/title.png">
    	</div>
        
   		<div id="featuredheader2"><a href="page-promotion.html">
        <img src="images/title2.png"></a>
		</div>
        
        <div id="featuredheader3"><a href="circuit-7-detail.html">
        <img src="images/title3.png"></a>
		</div>
        <div class="clear"></div>
		
        <!--ILLUSTRATIONS-->
     <span>
        <div id="featuredimg1">
         <img src="images/illustration_004.png">
        </div>
        
        <div id="featuredimg2"><a href="page-promotion.html">
        <img src="images/illustration_002.png"></a>
		</div>
        
        <div id="featuredimg3"> <a href="circuit-7-detail.html">
        <img src="images/illustration_003.png"></a>
		</div>
     </span>   
		<div class="clear"></div>
		
        <!--TEXTE-->
        
    	<div id="featured1">
		<div class="circuitindex">
<form method="get" action="index.php?mod=circuit">
		<label for="destination">Votre destination : </label>
		<select name="destination" id="destination">
			<option value="0"> - Selection - </option>
<?php	
	if( !count($liste_pays) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste_pays retourne 1 on affiche
	else { 
		foreach ($liste_pays as $item) : 
			$id_pays = intval($item['num_pays']);
			$nom_pays = stripslashes(htmlspecialchars( $item['nom_pays'] ));
				echo '<option value="'.$id_pays.'" ';
		 			if($id_pays != 0) {
						if ( $destination == $id_pays ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_pays.'</option>',"\n";
		endforeach;

		}
?>
		</select>
		
		
		<label for="ville_eta">Etape : </label>
		<select name="ville_eta" id="ville_eta">
			<option value="0"> - Selection - </option>
<?php	
	if( !count($liste_ville) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		$pays_en_cours ='';
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
						if ( $ville_eta == $id_ville ) 
							{ echo 'selected'; } 
					}
					echo'>'.$nom_ville.'</option>',"\n";

		endforeach;

		}
?>
		</select>
		
		
		<label for="duree">Durée du séjour : </label>
		<select name="duree" id="duree">
			<option value="0"> - Selection - </option>
			<option value="1" <?php if ( $duree == 1 ){ echo 'selected'; } ?>>Moins de 7 jours</option>
			<option value="2" <?php if ( $duree == 2 ){ echo 'selected'; } ?>>Plus de 7 jours</option>
			<option value="3" <?php if ( $duree == 3 ){ echo 'selected'; } ?>>Plus de 15 jours</option>
		</select>
		
		
		<label for="date_dep">Date de départ: </label>
		<select name="date_dep" id="date_dep">
			<option value="0"> - Selection - </option>
<?php	
	if( !count($liste_prog) )
	{
		echo '<p>La table semble être vide !</p>';
	}
	//Si $liste retourne 1 on affiche
	else { 
		foreach ($liste_prog as $item) : 
			$prog_cir = intval($item['prog_cir']);
			$date_depart = stripslashes(htmlspecialchars( $item['date_dep'] ));
				echo '<option value="'.$prog_cir.'" ';
		 			if($prog_cir != 0) {
						if ( $date_dep == $prog_cir ) 
							{ echo 'selected'; } 
					}
					echo'>'.$date_depart.'</option>',"\n";
		endforeach;

		}
?>
		</select>
		
		
		<label for="prix_min">Prix minimun : </label>
		<input type="text" name="prix_min" placeholder="Prix minimun" value="" />
		
		<label for="prix_max">Prix maximum : </label>
		<input type="text" name="prix_max" placeholder="Prix maximum" value="" />
		
		<input type="hidden" name="mod" value="circuit" />
		<input type="submit" value="Rechercher" />
</form>
        </div>
    	</div>
        
  		<div id="featured2">
        <p>
		Votre valise trépigne d'impatience... Et oui, les vacances de février c'est parti! A vous soleil et escapades citadines à tout petits prix! Nos équipes ont négocié pour vous des promos exceptionnelles allant jusqu'à <b>-50%!</b> Entre séjours et week-ends prolongés au départ de toute la France, vous n'avez que l'embarras du choix...
        </p>
        <h5>Notre sélection pour vos vacances:</h5>
        <h9>Une semaine d'évasion en Ecosse: réservez maintenant et obtenez une <b>réduction de -30%!</b> Soit <b>450€ au lieu de 680€!</b></h9><br><br>
        <h9>Offrez-vous un peu de <b>soleil en Sicile avec -20% </b>sur le prix total du séjour!</h9><br>
        <a href="page-promotion.html"><img src="images/nosselections.png"></a>
		</div>
    
    	 

		<div  id="featured3">
        <p>
		Envie d’un peu de mystère? Remontez le temps jusqu’au 13ème siècle, âge d’or des Templiers. Découvrez la région de l’Ordre célèbre, ses richesses accumulées pendant la guerre Sainte et les croisades. Mythodos a tout prévu pour vous faire vivre 5 jours légendaires!
        </p><br>
        <h5>Au programme:</h5><br><br>
        <h9><b>Au départ de Lille,</b> vous passerez par <b>Toulouse, Millau, </b>vous visiterez<b> La Cavalerie, La Couvertoriade, Saint-Jean d’Alcas, Sainte Eulalie de Cernon</b> et finirez par la magnifique<b> La Viala du Pas de Jaux</b>.</h9> <br><br>
        <a href="circuit-7-detail.html"><img src="images/iconprixspecial.png"></a>
        </div>
  
</span>

</div> <!-- ferme singlerectangle --> 