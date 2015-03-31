<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

require('includes/captcha/php-captcha.inc.php'); 

if (!empty($_POST)) // On verifie que l'on transmet bien quelque chose
{
	
     // La variable $verif va nous permettre d'analyser si la sémantique de l'e-mail est bonne
     $verif = "#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#";
 
     // On assigne et protège nos variables
	 $objet		= htmlspecialchars($_POST['objet']);
	 $pseudo	= htmlspecialchars($_POST['pseudo'])."\r\n";
     $from		= htmlspecialchars("From: ".$email."\r\n"); 
     $message	= stripslashes(trim(htmlspecialchars(utf8_decode($_POST["message"]))));
     $message	= str_replace('&amp;', 'et', $message);
     $destinataire = intval($_POST['des']);
	 
	 // enregistre les données du formulaire dans une session
	 $Session->saveForm();

		 if ($destinataire == 1)
		 {
			 $des_email = 'mickael.vb@orange.fr';
		 }
		 elseif ($destinataire == 2)
		 {
			 $des_email = 'mickael.vb@orange.fr';
		 }
		 else 
		 {
			$Session->setFlash('Vous devez selectionner une personne à contacter.','danger',CURRENT_PAGE); 
		 }
		 
		 /* Sujet du message */
		 if (empty($objet))
		 {
			$Session->setFlash('Vous devez indiquer l\'objet de votre message.','danger',CURRENT_PAGE); 
		 }
		 
		 /* Pseudo */
		 elseif (empty($pseudo))
		 {
			$Session->setFlash('Vous devez indiquer votre nom.','danger',CURRENT_PAGE); 
		 }
	 
		 // on vérifie si l'e-mail est valide grâce à la REGEX
		 elseif (!preg_match($verif,$_POST["email"]))
		 {
			$Session->setFlash('L\'adresse de courrier &eacute;lectronique n\'est pas valide.','danger',CURRENT_PAGE); 
		 }
	 
		 // On vérifie s'il y a un message
		 elseif (empty($message) && strlen($message)>10)
		 {
			$Session->setFlash('Vous devez &eacute;crire un message.','danger',CURRENT_PAGE); 
		 }
	 
		 elseif (!PhpCaptcha::Validate($_POST['code'])) {
			$Session->setFlash('Le code de confirmation ne correspond pas à celui indiqué sur l\'image.','danger',CURRENT_PAGE); 
		 }

		 else { // Si tout est ok, on envoie l'e-mail
				$content = 'Nom : ' . $pseudo . 'Message : '.$message;
				mail($des_email, $objet, $content, $from);
				$Session->setFlash('Votre message a bien &eacute;t&eacute; envoy&eacute;.','success',CURRENT_PAGE); 

		}
}

	  
	// On inclus le tpl
	include(dirname(__FILE__).'/vue.php');
?>