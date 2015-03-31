<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Paiement par carte bancaire';
?>
<div id="singlerectangle">

<div class="circuittitre">Procéder au paiement par carte bancaire</div>
	<div class="circuit">	

<b>Paiement sécurisé</b>

<br />
<h3>Montant total soit : <?php echo $prix_total; ?></h3>

<form action="index.php?mod=<?php echo $mod; ?>&amp;action=recap" method="post">

	<label for="nom">* Titulaire : </label><input id="nom" type="text" name="nom" maxlength="25" placeholder="Nom et prénom" />
	<br />

	<label for="carte">* Numéro de carte : </label><input id="carte" type="text" name="carte" maxlength="25" placeholder="Numéro de carte" />
	<br />	
	
	<label for="expir_date">* Date d'expiration : </label>
<?php
 echo '<select name="mois">';
		for($i = 1; $i<= 12; $i++){
			 echo '<option value="'. $i . '">'.utf8_encode(ucfirst(strftime('%B', strtotime(date('Y').'-'.$i)))).'</option>',"\n";
		}
echo '</select>',"\n";
?>

<?php
 echo '<select name="annee">';
		for ($annee = date('Y'); $annee <= date('Y')+3; $annee++) {
			 echo '<option value="'. $annee .'">'.$annee.'</option>',"\n";
		}
echo '</select>',"\n";
?>
	
	<label for="crypto">* Cryptogramme : </label><input id="crypto" type="text" name="crypto" maxlength="25" placeholder="Cryptogramme" />	
	<br />	
	
	<input type="radio" name="type_carte" value="1" id="1" /><label class="form-inline" for="1">Master Card</label>
	<input type="radio" name="type_carte" value="2" id="2" /><label class="form-inline" for="2">Visa</label>
	<input type="radio" name="type_carte" value="3" id="3" /><label class="form-inline" for="3">Carte bleue</label>
	<input type="radio" name="type_carte" value="4" id="4" /><label class="form-inline" for="4">American Express</label>
	<br /><br />
	<input type="hidden" name="paiement" id="paiement" value="<?php echo $paiement; ?>" /> <!-- numéro du circuit -->
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" /> <!-- numéro du circuit -->
	<input type="hidden" name="prog_cir" id="prog_cir" value="<?php echo $prog_cir; ?>" /> <!-- numéro de programme -->
	<input type="hidden" name="num_cli" id="num_cli" value="<?php echo $num_cli; ?>" /> <!-- numéro de client -->
	<input type="hidden" name="num_res" id="num_res" value="<?php echo $num_res; ?>" /> <!-- numéro de reservation -->
	<input type="hidden" name="nb_adulte" id="nb_adulte" value="<?php echo $nb_adulte; ?>" />
	<input type="hidden" name="nb_enfant" id="nb_enfant" value="<?php echo $nb_enfant; ?>" />
	<input type="hidden" name="nb_bebe" id="nb_bebe" value="<?php echo $nb_bebe; ?>" />
	<input type="submit" value="Valider">
</form>
<br />
<b>Note :</b> On imagine ici qu'au moment ou le client aura valider son paiement, le module de gestion externe nous retourne si ok ou non. Ici nous allons dire que le paiement peut être valider.
</div>

</div> <!-- ferme singlerectangle --> 