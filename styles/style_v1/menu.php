<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

include('./includes/menu_front/modele.php');
// <a href="index.php?mod=circuit&amp;id=&amp;action=detail"></a> <br />


		$liste_lien = liste_lien($bdd);
		
		foreach ($liste_lien as $item) :
			$id 			= intval($item['num_cir']);
			$nom_cir 		= stripslashes(htmlspecialchars( $item['nom_cir'] ));

			
endforeach;
?>

          <nav>
			<div id="container">
			   
			   <div class="box"><a href="index.html"><span class="lien_box"><h5>Accueil</h5></span></a></div>
			   <div class="box"><a href="page-presentation.html"><span class="lien_box"><h5>Présentation</h5></span></a></div>
			   <div class="box"><a href="circuit.html"><span class="lien_box"><h5>Circuits</h5></span></a></div>
			   <div class="box"><a href="page-nos-agences.html"><span class="lien_box"><h5>Nos Agences</h5></span></a></div>
			   <div class="box2"><a href="contact.html"><span class="lien_box"><h5>Contact</h5></span></a></div>
			   
			</div>
		    <div id="container">
				<a href="page-promotion.html"><div class="promo_ban"><img src="styles/style_v1/img/promosbanner.png"></div></a>
			</div>
          </nav>