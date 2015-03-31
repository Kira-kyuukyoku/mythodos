<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	/**********Vérification du titre...*************/
	$titre_page = (trim($titre_h1) != '') ? $titre_h1 . ' - ' . SITE_NAME : 'Administration ' . SITE_NAME;
	/***********Fin vérification titre...***********/
	
	$login = ( isset($_SESSION['pseudo']) ) ? ucfirst(htmlspecialchars($_SESSION['pseudo'])) : "visiteur";
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr" dir="ltr">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $titre_page; ?></title>
	<meta name="robots" content="noindex,nofollow" />
	<link rel="stylesheet" href="templates/css/reset.css" type="text/css" />
	<link rel="stylesheet" href="templates/css/style.css" type="text/css" />
	<link rel="stylesheet" href="templates/css/colorbox.css" type="text/css" />
	<link rel="stylesheet" href="templates/css/jquery-ui/themes/base/jquery.ui.all.css" type="text/css" />
</head>
<body>

<header>
<h1><?php echo $titre_h1; ?></h1>
<span class="header-droit">Bienvenue <?php echo $login; ?>.</span>
</header>

<div id="conteneur">
<?php
if( isset($_SESSION['pseudo']) ) // Affiche le contenus seulement si connecter
{
include_once(dirname(__FILE__).'/../includes/menu.php');
}
?>

<div id="content">
<?php 
	$Session->flash(); // class des erreurs
?>