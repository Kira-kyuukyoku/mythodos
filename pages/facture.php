<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

$titre_h1 = 'Facture';

	$dir_facture = 'factures/';
	$filename = htmlspecialchars($_GET['num_facture']);
	$url_complete = $dir_facture.'/facture-'.$filename.'.pdf';

if (!empty($_GET['num_facture']) && is_dir($dir_facture) && is_file($url_complete)) {

	$content = file_get_contents($url_complete);
	header("Content-Disposition: inline; filename='".$filename);
	header("Content-type: application/pdf");
	header('Cache-Control: private, max-age=0, must-revalidate');
	header('Pragma: public');

	echo $content;
}
else {

	$Session->setFlash('Aucune facture ne correspond à votre demande.','danger','index.php'); 
	exit;

}

?>