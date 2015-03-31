<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	$titre_h1 = 'Formulaire de contact';

	// récupére les infos du formulaire
	$Session->form();
	
if( !empty($_POST) ){
		extract($_POST);
		
	if( $_SESSION['flash']['type'] == 'success' ) // si le message a bien été envoyé, on affiche le récapitulatif
		{
	?>      <h2>Récapitulatif</h2>
			<p><b>Courriel pour la r&eacute;ponse&nbsp;:</b><br /><?php echo htmlspecialchars($email); ?></p>
			<p><b>Objet&nbsp;:</b><br /><?php echo htmlspecialchars($objet); ?></p>
			<p><b>Pseudo&nbsp;:</b><br /><?php echo htmlspecialchars($pseudo); ?></p>
			<p><b>Message&nbsp;:</b><br /><?php echo nl2br( htmlspecialchars(utf8_encode($message)) ); ?></p>
	<?php
			 unset($_POST, $email, $objet, $message);
			 $_POST = NULL;
		}
}


if (empty($_POST) ) {
	// On définit ou redéfinit nos valeurs par défaut.
	$objet = '';
	$pseudo = '';
	$email = '';
	$des = 0;
	$message = NULL;
}

	// Debug
    //print_r($_POST);
	//var_dump($_POST);
?>
<div id="singlerectangle">
<img src="styles/style_v1/img/contacteznous.png">
	<span>
	<p>Une question, une remarque? Notre équipe vous répond dans les plus brefs délais. Merci d'utiliser le formulaire ci-dessous. Pour nous contacter par téléphone ou par courrier, merci de vous rendre sur <a href="agences.html">cette page</a> pour obtenir les coordonnées de l'agence la plus proche de chez vous.</p>
	</span>


<span class="formulairecontact">
<form method="post" action="<?php echo CURRENT_PAGE; ?>" onSubmit="return verifContact(this);">

<div class="formulaire">
<label for="objet">Objet :</label>
<input type="text" name="objet" id="objet" size="28" value="<?php echo htmlspecialchars($objet); ?>" placeholder="Votre demande" autofocus />

<label for="pseudo">Pseudo :</label>
<input type="text" name="pseudo" id="pseudo" size="28" value="<?php echo htmlspecialchars($pseudo); ?>" placeholder="Votre pseudo / nom" />
</div>

<div class="formulaire">
<label for="email">Email :</label>
<input type="email" name="email" id="email" size="28" value="<?php echo $email; ?>"  placeholder="mail@domaine.com" />


     <label for="des">Contact :</label>
      <select name="des" id="des">
	  <option value="0" <?php if($des == 0) { echo 'selected="selected"';} ?>>Personne &agrave; contacter ?</option>
	  <option name="des" value="1" <?php if($des == 1) { echo 'selected="selected"';} ?>>Service client</option>
	  <option name="des" value="2" <?php if($des == 2) { echo 'selected="selected"';} ?>>Webmaster</option>
      </select>

</div>
	  
<p><label for="textarea">Votre message : </label>
<textarea id="textarea" cols="60" rows="8" name="message"><?php echo htmlspecialchars($message); ?></textarea></p>

<p><label for="verif">Recopiez le code : </label>
<input type="text" size="26" name="code" id="verif" maxlength="4" />
<img src="includes/captcha/captcha.php?width=115&amp;height=30" width="115" height="27" class="captcha" alt="Security Image" /></p>

<p>
<input type="reset" name="reset" value="Effacer" />
<input type="submit" value="Envoyer" />
</p>

	<div id="resultat"></div>

</form></span>
</div> <!-- ferme singlerectangle --> 