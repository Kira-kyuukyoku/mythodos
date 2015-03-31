<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " un pays";
?>
	<form method="post" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
		<label for="pays">* Pays : </label><input type="text" name="nom_pays" id="pays" placeholder="Nom" value="<?php echo $nom_pays; ?>" autofocus required /><br />
		<br />
		<u>* Devise :</u><br />
		<label for="euros" class="form-inline">Euros : </label> <input class="radio" type="radio" name="num_dev" value="0" id="euros" <?php if($num_dev == 0) { echo 'checked="checked"';} ?> /> 
		<label for="livre" class="form-inline">Livre sterling : </label> <input class="radio" type="radio" name="num_dev" value="1" id="livre" <?php if($num_dev == 1) { echo 'checked="checked"';} ?> />
<br /><br />
    <input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>