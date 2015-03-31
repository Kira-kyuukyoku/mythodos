<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');
?>

<div class="circuitautre">
<div id="etape"><a id="detail"></a>
<h2>Les étapes</h2>
<?php
	if( !count($liste_etape) )
	{
		echo '<p>Aucune étape pour ce séjour.</p>';
	}
	else
	{

		foreach ($liste_etape as $item) : 
			$num_eta 		= intval($item['num_eta']);
			$purifier 		= new HTMLPurifier();
			$desc_eta 		= $purifier->purify($item['desc_eta']);
			$dur_eta 		= intval( $item['dur_eta'] );
			$nom_ville 		= stripslashes(htmlspecialchars( $item['nom_ville'] ));
?>
<h5>Etape : <?php echo $num_eta . ' - ' . $nom_ville; ?></h5>
<h5>Durée : <?php echo $dur_eta; ?>j </h5>
<?php echo $desc_eta; ?><br />
<br />

<?php
		endforeach;
?>

</div>
</div>
<?php
} // fin else etape
?>