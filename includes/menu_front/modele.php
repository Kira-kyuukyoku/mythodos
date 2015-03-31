<?php
function liste_lien($bdd){
	$liste = array();
	$sql = "SELECT SQL_NO_CACHE num_cir, nom_cir FROM circuit ORDER BY RAND() LIMIT 5";
	$reponse = $bdd->query($sql) or die($bdd->error); 
	if($reponse->num_rows != 0) {
        while ($data = $reponse->fetch_assoc())
        {
                $liste[] = $data;
		}
	}
		$reponse->free_result();
 
	return $liste;
}