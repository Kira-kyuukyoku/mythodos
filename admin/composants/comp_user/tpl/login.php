<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

		// Définit le titre de la page
		$titre_h1 = "Connexion";
?>
<h2><?php echo $titre_h1; ?></h2>

	<div id="block-login">
	<p>User: admin | Password : cnam</p>
		<form action="index.php?comp=programme" method="POST">
		<p>
			<label for="login">Login :</label> 
			<input type="text" name="login" value="" placeholder="Nom d'utilisateur" required="" autofocus="" /> <br />
			<label for="mdp">Mot de passe :</label>
			<input type="password" name="mdp" value="" placeholder="Password" required="" /> <br />
			<input type="submit" value="Se connecter" />
		</p>
		</form>
	</div>