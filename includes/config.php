<?php //CONSTANTE
define('INDEX', true); // no direct access

define('ROOT', 'http://'.$_SERVER['HTTP_HOST'].'/', true); /*SITE*/
define('URL_PAGE', $_SERVER['PHP_SELF'], true);
define('SITE_NAME', 'Mythodos Travel Agency - Voyages vers les lieux de légendes européens', true);
define('META_DESC', 'Mythodos Travel Agency est une agence de voyages spécialisée dans les circuits vers les lieux les plus mythiques et légendaires d\'Europe.', true);
define('META_TAGS', 'voyage, voyages, agence, europe, Europe, mythes, circuits, légendes, lieux, lieux légendaires, Lille, Ecosse, France, Espagne, Grande-Bretagne, Allemagne, Belgique, Sicile, Italie, contes', true);

///******  ADMINISTRATION  ******////
define('ROOT_ADMIN', 'http://'.$_SERVER['HTTP_HOST'].'/admin/', true);
define('MAX_ITEM_PAR_PAGE', '15', true);

?>