<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = $titre_action . " un commentaire";
?>
	<form method="post" enctype="multipart/form-data" action="index.php?comp=<?php echo $comp ?>&amp;id=<?php echo $id ?>&amp;action=verification">
       
		<label for="pseudo">* Pseudo : </label><input type="text" name="pseudo_com" id="pseudo" value="<?php echo $pseudo_com; ?>" autofocus required /><br />
		<br />
		
		<label for="message">* Message: </label>
		<textarea id="message" name="mess_com" rows="7" cols="50"><?php echo $mess_com; ?></textarea>
<br /><br />	
		
<br /><br />
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
	<input type="submit" value="Envoyer" />
	</form>