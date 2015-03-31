<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Réservation';
?>
<div id="singlerectangle">

<div class="circuittitre">Récapitulatif de votre commande</div>
<div class="circuit">	
<div class="circuitdroite"><a class="colorbox" href="images/villes/<?php echo $img_dep; ?>"><img src="images/villes/mini/<?php echo $img_dep; ?>" alt="<?php echo $ville_dep; ?>" /></a></div>
<b>Circuit : </b><?php echo $nom_cir; ?><br />
<b>Ville de départ : </b><?php echo $ville_dep; ?><br />
<b>Date de départ : </b><?php echo $proch_dep; ?><br />
<b>Date de retour : </b><?php echo $date_retour; ?><br />
<b>Durée : </b><?php echo $jour_total; ?> jours / <?php echo $nuit_total; ?><br />
<b>Destination: </b><?php echo $pays_depart; ?><br />
<b>Nbre de personne : </b><?php echo $total_voy; ?><br />
<b>Voyage: </b><?php echo $prix_cir.$devise; ?><br />
<b>Monuments : </b><?php echo $prix_mon.$devise; ?><br />
<h3>Total : <?php echo $prix_total; ?><h3>
</div>


<div class="circuittitre">Vos informations</div>
<div class="circuit">	
<form action="index.php?mod=<?php echo $mod; ?>&amp;action=paiement" method="post" onSubmit="return verifClient(this);">
<div class="formulaire">
	<h2>Vos Coordonnées</h2>

	<label for="civ_cli">* Civilité : </label>
	<select name="civ_cli" id="civ_cli">
		<option value="0"> - </option>
		<option value="1" <?php if ($civ_cli == 1){echo ' selected="selected" ';} ?>>Mr</option>
		<option value="2" <?php if ($civ_cli == 2){echo ' selected="selected" ';} ?>>Mme</option>
	</select>

	<label for="nom_cli">* Nom : </label><input id="nom_cli" type="text" name="nom_cli" maxlength="25" placeholder="Nom" value="<?=$nom_cli?>" />

	<label for="pren_cli">* Prenom : </label><input type="text" id="pren_cli" name="pren_cli" maxlength="25" placeholder="Prénom" value="<?=$pren_cli?>" />
	<br />

	<label for="tel_cli">* Numéro de téléphone : </label><input type="tel" id="tel_cli" name="tel_cli" placeholder="N° de tél." value="<?=$tel_cli?>" />

	<label for="tel2_cli">Numéro de téléphone 2 : </label><input type="tel" id="tel2_cli" name="tel2_cli" placeholder="Facultatif" value="<?=$tel2_cli?>" />
	<br />

	<label for="mail_cli">* Adresse email : </label><input type="email" id="mail_cli" name="mail_cli" id="client_email" maxlength="45" value="<?=$mail_cli?>" placeholder="Adresse email" />
	
	<label for="emailConfirm">* Retapez votre adresse email : </label><input type="emailConfirm" id="emailConfirm" name="emailConfirm" placeholder="Retapez l'email" equals="email" err="L'adresse email doit être la même que celle que vous venez d'entrer" value="<?=$emailConfirm?>" />
	<br />
</div>
<div class="formulaire">
	<h2>Adresse de facturation</h2>

	<label for="ad_cli">* Adresse : </label><input type="text" id="ad_cli" name="ad_cli" value="<?=$ad_cli?>" placeholder="Entrez votre adresse" /><br />

	<label for="ville_cli">* Ville : </label><input type="text" id="ville_cli" name="ville_cli" value="<?=$ville_cli?>" placeholder="Ville" />

	<label for="cp_cli">* Code Postal : </label><input type="number" id="cp_cli" name="cp_cli" value="<?=$cp_cli?>" placeholder="Code Postal" maxlength="5" />
	
	<label for="pays_cli">* Pays : </label><input type="text" id="pays_cli" name="pays_cli" value="<?=$pays_cli?>" placeholder="Pays" />
	<br />
	
	
	<h2>Mode de réglement</h2>
	<input class="form-inline" type="radio" name="paiement" value="1" id="1" <?php if ($paiement == 1){echo ' checked="checked" ';} ?>/><label class="form-inline" for="1">Carte bleue</label> &nbsp;&nbsp;&nbsp; 
	<input class="form-inline" type="radio" name="paiement" value="2" id="2" <?php if ($paiement == 2){echo ' checked="checked" ';} ?>/><label class="form-inline" for="2">Chéque</label>
	<br />
</div>
</div>

<div class="clear"></div>	


<div class="circuittitre">Voyageurs</div>
<div class="circuit">	
<?php // On vérifie en premier lieu si il s'agit d'un renvoi du formulaire
if(isset($_POST["civ_voy"]) && isset($_POST["civ_voy"]) && isset($_POST["civ_voy"]) && isset($_POST["civ_voy"]) && isset($_POST["nais_voy"])) {

	$voy = 0;

	for($i=1; $i<=$total_voy; $i++)
	{
			// On stocke temporairement les données pour cette personne
			$civ_voy	= ($_POST["civ_voy"][$voy] != 0) 		? intval($_POST["civ_voy"][$voy]) : 0;
			$nom_voy	= (!empty($_POST["nom_voy"][$voy]))		? stripslashes(htmlspecialchars( $_POST["nom_voy"][$voy] )) : '';
			$pren_voy	= (!empty($_POST["pren_voy"][$voy]))	? stripslashes(htmlspecialchars( $_POST["pren_voy"][$voy] )) : '';
			$type_voy	= ($_POST["type_voy"][$voy] != 0)		? intval($_POST["type_voy"][$voy]) : 0;
			$nais_voy	= (!empty($_POST["nais_voy"][$voy]))	? htmlspecialchars( $_POST["nais_voy"][$voy]) : '';
			
			if($type_voy == 1) {
				$nom_type = 'Adulte';
			}
			elseif($type_voy == 2) {
				$nom_type = 'Enfant';
			}
			else{
				$nom_type = 'Bébé';
			}
							
?>
	<b><?php echo $nom_type; ?> : </b>
	<label for="civ_<?php echo 'ad'.$i; ?>">* Civilité : </label>
	<select name="civ_voy[]">
		<option value="0"> - </option>
		<option value="1" <?php if($civ_voy == 1 ){ echo 'selected="selected"'; } ?>>Mr</option>
		<option value="2" <?php if($civ_voy == 2 ){ echo 'selected="selected"'; } ?>>Mme</option>
	</select>

	<label for="nom_<?php echo 'ad'.$i; ?>">* Nom : </label><input id="nom_<?php echo 'ad'.$i; ?>" type="text" name="nom_voy[]" maxlength="25" placeholder="Nom" value="<?php echo $nom_voy; ?>" required />

	<label for="prenom_<?php echo 'ad'.$i; ?>">* Prenom : </label><input id="prenom_<?php echo 'ad'.$i; ?>" type="text" name="pren_voy[]" maxlength="25" placeholder="Prénom" value="<?php echo $pren_voy; ?>" required />
	<br />
	<label for="nais_voy_<?php echo 'ad'.$i; ?>">* Date de naissance : </label><input id="nais_voy_<?php echo 'ad'.$i; ?>" type="date" class="datepicker" name="nais_voy[]" placeholder="jj-mm-aaaa" value="<?php echo $nais_voy; ?>" required /><br />
	<input type="hidden" name="type_voy[]" value="<?php echo $type_voy; ?>" /><br />
<?php

	$voy++;
	}
}
else { // Si il s'agit du premier affichage du formulaire
	
	// On génére le formulaire pour les adultes
	for ($i=1; $i<=$nb_adulte; $i++){

	echo '<b>Adulte '.$i.'</b>'; ?>
	<label for="civ_<?php echo 'ad'.$i; ?>">* Civilité : </label>
	<select name="civ_voy[]">
		<option value="0"> - </option>
		<option value="1">Mr</option>
		<option value="2">Mme</option>
	</select>

	<label for="nom_<?php echo 'ad'.$i; ?>">* Nom : </label><input id="nom_<?php echo 'ad'.$i; ?>" type="text" name="nom_voy[]" maxlength="25" placeholder="Nom" value="" required />

	<label for="prenom_<?php echo 'ad'.$i; ?>">* Prenom : </label><input id="prenom_<?php echo 'ad'.$i; ?>" type="text" name="pren_voy[]" maxlength="25" placeholder="Prénom" required />
	<br />
	<label for="nais_voy_<?php echo 'ad'.$i; ?>">* Date de naissance : </label><input id="nais_voy_<?php echo 'ad'.$i; ?>" type="date" class="datepicker" name="nais_voy[]" placeholder="jj-mm-aaaa" value="" required /><br />
	<input type="hidden" name="type_voy[]" value="1" /><br />
<?php
	}
	
	
	// On génére le formulaire pour les enfants
	for ($i=1; $i<=$nb_enfant; $i++){
?>
	<?php echo '<b>Enfant '.$i.'</b>'; ?> : 
	<label for="civ_<?php echo 'enf'.$i; ?>">* Civilité : </label>
	<select name="civ_voy[]">
		<option value="0"> - </option>
		<option value="1">Mr</option>
		<option value="2">Mme</option>
	</select>

	<label for="nom_<?php echo 'enf'.$i; ?>">* Nom : </label><input id="nom_<?php echo 'enf'.$i; ?>" type="text" name="nom_voy[]" maxlength="25" placeholder="Nom" value="" required />

	<label for="prenom_<?php echo 'enf'.$i; ?>">* Prenom : </label><input id="prenom_<?php echo 'enf'.$i; ?>" type="text" name="pren_voy[]" maxlength="25" placeholder="Prénom" required />
	<br />
	<label for="nais_voy_<?php echo 'enf'.$i; ?>">* Date de naissance : </label><input id="nais_voy_<?php echo 'enf'.$i; ?>" type="date" class="datepicker" name="nais_voy[]" placeholder="jj-mm-aaaa" value="" required /><br />
	<input type="hidden" name="type_voy[]" value="2" /><br />
<?php
	}
	
	// On génére le formulaire pour les bébés
	for ($i=1; $i<=$nb_bebe; $i++){
?>
	<?php echo '<b>Bébé '.$i.'</b>'; ?> : 
	<label for="civ_<?php echo 'bebe'.$i; ?>">* Civilité : </label>
	<select name="civ_voy[]">
		<option value="0"> - </option>
		<option value="1">Mr</option>
		<option value="2">Mme</option>
	</select>

	<label for="nom_<?php echo 'bebe'.$i; ?>">* Nom : </label><input id="nom_<?php echo 'bebe'.$i; ?>" type="text" name="nom_voy[]" maxlength="25" placeholder="Nom" value="" required />

	<label for="prenom_<?php echo 'bebe'.$i; ?>">* Prenom : </label><input id="prenom_<?php echo 'bebe'.$i; ?>" type="text" name="pren_voy[]" maxlength="25" placeholder="Prénom" required />
	<br />
	<label for="nais_voy_<?php echo 'bebe'.$i; ?>">* Date de naissance : </label><input id="nais_voy_<?php echo 'bebe'.$i; ?>" type="date" class="datepicker" name="nais_voy[]" placeholder="jj-mm-aaaa" value="" required /><br />
	<input type="hidden" name="type_voy[]" value="3" /><br />
<?php
	}
	
} // fin du else $_POST
?>	
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="hidden" name="prog_cir" id="prog_cir" value="<?php echo $prog_cir; ?>" />
	<input type="hidden" name="nb_adulte" id="nb_adulte" value="<?php echo $nb_adulte; ?>" />
	<input type="hidden" name="nb_enfant" id="nb_enfant" value="<?php echo $nb_enfant; ?>" />
	<input type="hidden" name="nb_bebe" id="nb_bebe" value="<?php echo $nb_bebe; ?>" />
	<input type="checkbox" name="cgv" id="cgv" /><label for="cgv">J'ai pris connaissance et accepte les conditions de vente.</label>
	<br /><br />
	<a href="index.php?mod=circuit&amp;id=<?php echo $id; ?>&amp;action=detail" class="cancel">Annuler</a> <input type="submit" value="Valider">
	
		<div id="resultat"></div>
		
	</div>
		
</div> <!-- ferme singlerectangle --> 