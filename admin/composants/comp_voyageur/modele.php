<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_voyageur($bdd){
	$liste = array();
	$sql = "SELECT num_voy, civ_voy, nom_voy, pren_voy FROM voyageur ORDER BY num_voy DESC";
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

function voir_voyageur($bdd, $id){
	$sql = "SELECT num_voy, num_cli, civ_voy, nom_voy, pren_voy, type_voy, DATE_FORMAT(nais_voy,'%d-%m-%Y') AS nais_voy FROM voyageur WHERE num_voy = ".$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function update_voyageur($bdd, $id, $num_cli, $civ, $nom, $prenom, $type, $nais){
	$sql = 'UPDATE voyageur SET num_cli = "'.$num_cli.'", civ_voy = "'.$civ.'", nom_voy = "'.$nom.'", pren_voy="' . $prenom . '", type_voy = "'.$type.'", 
	nais_voy = "'.$nais.'" 
	WHERE num_voy = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}	