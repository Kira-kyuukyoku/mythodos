<?php
require(dirname(__FILE__).'/../includes/session.class.php');
$Session = new Session(); // on démarre une nouvelle session

include_once(dirname(__FILE__).'/../includes/config.php');
include_once(dirname(__FILE__).'/../includes/function-global.php');

		// Définit la page courante
		$current_page = (!empty($_GET['comp']) && $_GET['comp'] != 'users') ? '?comp='.htmlspecialchars($_GET["comp"]) : '';
		define('CURRENT_PAGE', $_SERVER['PHP_SELF'].$current_page, true);

		// PAGINATION
		$page 		= (isset($_GET['page'])) ? intval($_GET['page']) : 1;

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

if(isset($_SESSION['pseudo'])) //Afficher le contenus de la page seulement si connecter
{

	// Connexion à la BDD
	include_once(dirname(__FILE__).'/../includes/sql.php');
	$bdd = connexion_DB();

	if(!empty($_GET['comp']))
	{
		// On sécurise nos variables
		$comp = htmlentities($_GET["comp"], ENT_QUOTES);
		$id = (!empty($_GET['id'])) ? (int) $_GET['id'] : 0;

		// Si l'action est specifiée, on l'utilise, sinon, on tente une action par défaut
		$action = (!empty($_GET['action'])) ? htmlspecialchars($_GET['action']).'.php' : 'index.php';

		if (is_dir('composants/comp_'.$comp) )
		{
			$composant = dirname(__FILE__).'/composants/comp_'.$comp.'/index.php';

			// Si le fichier existe, on l'exécute
			if (is_file($composant)) {
				include $composant;
			// Sinon, on affiche la page d'accueil
			} else {
				include ('composants/comp_accueil/index.php');
			}
		}
		else
		{
			// On inclue la page 404
			include('includes/404.php');
		}
	}
	else
	{
		// Inclusion de la page par défaut
		include ('composants/comp_accueil/index.php');
	}

} // Si non connecter on inclus le formulaire de connection
else
{
	include_once(dirname(__FILE__).'/composants/comp_user/index.php');
}

	// Fin de la tamporisation de sortie
	$contenu = ob_get_clean();

	include_once(dirname(__FILE__).'/includes/header.php');

	echo $contenu;

	include_once(dirname(__FILE__).'/includes/footer.php');

if(isset($_SESSION['pseudo'])) {
	$bdd->close();
	}
?>