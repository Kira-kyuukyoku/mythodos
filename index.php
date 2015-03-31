<?php
require(dirname(__FILE__).'/includes/session.class.php');
$Session = new Session(); // on démarre une nouvelle session

	// Permet de traduite les mois en français
	setlocale(LC_TIME, 'fr_FR.UTF8','fra', 'french');

include_once(dirname(__FILE__).'/includes/config.php');

// Library HTMLPurifier
require_once(dirname(__FILE__).'/includes/HTMLPurifier/HTMLPurifier.auto.php');

		// Définit la page courante		
		if (!empty($_GET['mod'])) {
			$current_page = '?mod='.htmlspecialchars($_GET['mod']);
		}
		elseif (!empty($_GET['page'])) {
			$current_page = '?page='.htmlspecialchars($_GET['page']);
		}
		else {
			$current_page = '';
		}
			define('CURRENT_PAGE', 'index.php'.$current_page, true);
		
		
// Fonction qui supprime l'effet des magic quotes, retire tout les backslash (\) en trop
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc())
{
	function stripslashes_deep($value)
	{
		return is_array($value) ?
			array_map('stripslashes_deep', $value) : stripslashes($value);
	}
	$_POST    = array_map('stripslashes_deep', $_POST);
	$_GET     = array_map('stripslashes_deep', $_GET);
	$_COOKIE  = array_map('stripslashes_deep', $_COOKIE);
	$_REQUEST = array_map('stripslashes_deep', $_REQUEST);
}

// Début de la tamporisation de sortie
ob_start();

	// Connexion à la BDD
	include_once(dirname(__FILE__).'/includes/sql.php');
	$bdd = connexion_DB();

	if(!empty($_GET['mod']))
	{
		// On sécurise nos variables
		$mod	= htmlentities($_GET["mod"], ENT_QUOTES);
		$id 	= (!empty($_GET['id'])) ? (int) $_GET['id'] : 0;
	  
		// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
		$action = (!empty($_GET['action'])) ? htmlspecialchars($_GET['action']).'.php' : 'index.php';
   
		if (is_dir('modules/mod_'.$mod) )
		{
			$module = dirname(__FILE__).'/modules/mod_'.$mod.'/index.php';
	
			// Si le fichier existe, on l'exécute
			if (is_file($module)) {
				include $module;
			// Sinon, on affiche la page d'accueil
			} else {
				include (dirname(__FILE__).'/pages/404.php');
			}
		}
		else
		{
			// On inclue la page 404
			include(dirname(__FILE__).'/pages/404.php');
		}
	}
	
	elseif (!empty($_GET['page'])){
		// On sécurise nos variables
		$page = htmlentities($_GET["page"], ENT_QUOTES);
	  
		// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
		$action = (!empty($_GET['action'])) ? htmlspecialchars($_GET['action']).'.php' : 'index.php';
   
		if (is_dir('pages') )
		{
			$page = dirname(__FILE__).'/pages/'.$page.'.php';
	
			// Si le fichier existe, on l'exécute
			if (is_file($page)) {
				include $page;
			// Sinon, on affiche la page d'accueil
			} else {
				include (dirname(__FILE__).'/pages/404.php');
			}
		}
		else
		{
			// On inclue la page 404
			include(dirname(__FILE__).'/pages/404.php');
		}
	}
	else
	{
		// Inclusion de la page par défaut
		include (dirname(__FILE__).'/modules/mod_index/index.php');
	}


	// Fin de la tamporisation de sortie
	$contenu = ob_get_clean();

	include_once(dirname(__FILE__).'/styles/style_v1/header.php');

	echo $contenu;
	 
	include_once(dirname(__FILE__).'/styles/style_v1/footer.php');

	$bdd->close(); 

?>