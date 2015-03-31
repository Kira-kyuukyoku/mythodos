<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

	/**********Vérification du titre...*************/
	$titre_page = (trim($titre_h1) != '') ? $titre_h1 . ' - ' . SITE_NAME : SITE_NAME;
	/***********Fin vérification titre...***********/
?>
<!doctype html>
<html lang="fr">
<head>
	<meta charset="UTF-8" />
	<title><?php echo $titre_page; ?></title>
	<meta name="description" content="<?php echo META_DESC; ?>" />
	<meta name="keywords" content="<?php echo META_TAGS; ?>" />
	<!--Support pour les anciens navigateurs-->
	<link rel="stylesheet" media="screen" type="text/css" href="styles/style_v1/css/normalize.css" />
	<!-- Style du site -->
	<link rel="stylesheet" media="screen" type="text/css" href="styles/style_v1/css/mythodosstyle.css" />
	<!--Lien vers la CSS pour les appareils mobiles-->
	<link rel="stylesheet" href="styles/style_v1/css/device_styles.css" />
	<!--Icone qui apparait dans les onglets-->
	<link rel="shortcut icon" href="favicon.ico" />
	<!--Lien pour les anciennes versions d'IE-->
	<!--[if lt IE 9]!>
	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	
	<!-- CSS Jquery, Colorbox, Calendrier, Formulaire -->
	<link rel="stylesheet" media="screen" type="text/css" href="styles/style_v1/css/form.css" />
	<link rel="stylesheet" media="screen" type="text/css" href="styles/style_v1/css/colorbox.css" />
	<link rel="stylesheet" media="screen" type="text/css" href="styles/style_v1/css/jquery-ui/base/jquery.ui.all.css" />
</head>
<body>
<!-- GOOGLE ANALYTICS CODE -->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-48063140-1', 'free.fr');
  ga('send', 'pageview');

</script>
<!--FIN DU CODE ANALYTICS-->


<header>
      <div>
		<a href="index.html" title="Accueil"><img src="styles/style_v1/img/logo.png" alt="Bienvenue chez Mythodos" /></a>
      </div>
</header>

<?php 
include_once(dirname(__FILE__).'/menu.php');

	$Session->flash(); // class des erreurs
?>
