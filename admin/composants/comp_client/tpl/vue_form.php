<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " un client";
?>
	<form method="post" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
		<u>* Civilité :</u><br />
		<label for="monsieur" class="form-inline">Monsieur : </label> <input type="radio" name="civ_cli" value="1" id="monsieur" <?php if($civ_cli == 1) { echo 'checked="checked"';} ?> /> 
		<label for="madame" class="form-inline">Madame : </label> <input type="radio" name="civ_cli" value="2" id="madame" <?php if($civ_cli == 2) { echo 'checked="checked"';} ?>/>
<br /><br />

		<label for="nom">* Nom : </label><input type="text" name="nom_cli" id="nom" value="<?php echo $nom_cli; ?>" autofocus required /><br />
		<br />
		
		<label for="prenom">* Prénom : </label><input type="text" name="pren_cli" id="prenom" value="<?php echo $pren_cli; ?>" required /><br />
		<br />
		
		<label for="adresse">* Adresse : </label><input type="text" name="ad_cli" id="adresse" value="<?php echo $ad_cli; ?>" required /><br />
		<br />
		
		<label for="code_postal">* Code Postal : </label><input type="text" name="cp_cli" id="code_postal" value="<?php echo $cp_cli; ?>" required /><br />
		<br />
		
		<label for="ville">* Ville : </label><input type="text" name="ville_cli" id="ville" value="<?php echo $ville_cli; ?>" required /><br />
		<br />
		
		<label for="pays">* Pays : </label><input type="text" name="pays_cli" id="pays" value="<?php echo $pays_cli; ?>" required /><br />
		<br />
		
		<label for="tel1">* Téléphone : </label><input type="tel" name="tel_cli" id="tel1" value="<?php echo $tel_cli; ?>" required /><br />
		<br />
		
		<label for="tel2">* Téléphone 2 : </label><input type="tel" name="tel2_cli" id="tel2" value="<?php echo $tel2_cli; ?>" /><br />
		<br />
		
		<label for="email">* Email : </label><input type="email" name="mail_cli" id="email" value="<?php echo $mail_cli; ?>" required /><br />
		<br />

    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>