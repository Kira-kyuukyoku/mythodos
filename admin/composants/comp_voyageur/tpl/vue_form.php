<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " un voyageur";
?>
	<form method="post" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
		<u>* Civilité :</u><br />
		<label for="monsieur" class="form-inline">Monsieur : </label> <input type="radio" name="civ_voy" value="1" id="monsieur" <?php if($civ_voy == 1) { echo 'checked="checked"';} ?> /> 
		<label for="madame" class="form-inline">Madame : </label> <input type="radio" name="civ_voy" value="2" id="madame" <?php if($civ_voy == 2) { echo 'checked="checked"';} ?>/>
<br /><br />

		<label for="nom">* Nom : </label><input type="text" name="nom_voy" id="nom" value="<?php echo $nom_voy; ?>" required /><br />
		<br />
		
		<label for="prenom">* Prénom : </label><input type="text" name="pren_voy" id="prenom" value="<?php echo $pren_voy; ?>" required /><br />
		<br />
		
		<u>* Type :</u><br />
		<label for="adulte" class="form-inline">Adulte : </label> <input type="radio" name="type_voy" value="1" id="adulte" <?php if($type_voy == 1) { echo 'checked="checked"';} ?> /> 
		<label for="enfant" class="form-inline">Enfant : </label> <input type="radio" name="type_voy" value="2" id="enfant" <?php if($type_voy == 2) { echo 'checked="checked"';} ?>/>
<br /><br />
		
		<label for="nais">* Date de naissance : </label><input type="date" name="nais_voy" id="nais" class="datepicker" value="<?php echo $nais_voy; ?>" required /><br />
		<br />

    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
    <input type="hidden" name="num_cli" id="num_cli" value="<?php echo $num_cli; ?>" />
	<input type="submit" value="Envoyer" />
	</form>