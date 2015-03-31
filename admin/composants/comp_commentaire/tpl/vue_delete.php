<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Confirmer la suppréssion";
?>
<h2>Confirmez vous la suppression?</h2>

<form action="" method="post">
	<input type="hidden" name="confirmation" value="<?php echo $id; ?>">
	<input type="submit" value="Supprimer"> <input type="submit" name="annuler" value="Annuler" onClick="history.back();return false;">
</form>