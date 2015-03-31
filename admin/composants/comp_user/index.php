<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

// **************** VERIFICATION DE LA DEMANDE DE DECONNEXION ****************

// Si on reçoit en paramètre "$_POST['deconnexion']".
if(isset($_POST['deconnexion']))
{
	// Si c'est une demande de déconnexion, on détruit la session en cours et on charge la page de déconnexion.
	if ($_POST['deconnexion'] == true )
	{
		$_SESSION = array(); // vide la variable de son contenu
	
		session_destroy();  // detruit ma session
		
		$Session = new Session(); // on démarre une nouvelle session
		$Session->setFlash('Vous êtes à présent deconnecté du panneau d\'administration.','success','index.php'); 
	}
}

// **************** VERIFICATION DE LA SAISIE DU LOGIN ET DU MOT DE PASSE ****************
elseif (isset($_POST['login']) AND isset($_POST['mdp']))
{

		// Mesures de sécurité.
		$login 	= (isset($_POST['login'])) ? htmlspecialchars(trim($_POST['login'])) : '';
		$mdp	= (isset($_POST['mdp'])) ? sha1(htmlspecialchars(trim($_POST['mdp']))) : '';

	// Si "$_POST['login']" ET "$_POST['mdp']" contiennent quelque chose.
	if ($login!=NULL AND $mdp!=NULL)
	{
		
			// Si "$resultat" est "false", c'est que le login saisi est faux.
			if ($login != 'admin')
			{
				$Session->setFlash('Pseudonyme erroné.','danger','index.php'); 
			}
			
			// Sinon si les mots de passe ne correspondent c'est que celui saisi est faux.
			elseif($mdp != sha1('cnam'))
			{
				$Session->setFlash('Mot de passe erroné.','danger','index.php'); 
			}
			
			// Sinon l'utilisateur est authentifié ; on ajoute le nom à la session en cours
			else
			{
				$_SESSION['pseudo'] = $login;
				$Session->setFlash('Connexion réussis !','success','index.php?comp=programme'); 
			}
			
		// Affiche le formulaire de connexion
		include_once(dirname(__FILE__).'/tpl/login.php');
		
	}
	else
	{
			$Session->setFlash('Veuillez remplir tous les champs avant validation','warning','index.php');
	}
}
else {
		// Affiche le formulaire de connexion
		include_once(dirname(__FILE__).'/tpl/login.php');
}
?>