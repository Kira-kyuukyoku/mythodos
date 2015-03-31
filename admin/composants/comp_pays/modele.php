<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_pays($bdd){
	$liste = array();
	$sql = "SELECT num_pays, nom_pays, num_dev FROM pays ORDER BY num_pays DESC";
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

function voir_pays($bdd, $id){
	$sql = 'SELECT num_pays, nom_pays, num_dev FROM pays WHERE num_pays = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_pays($bdd, $id){
	$sql = 'DELETE FROM pays WHERE num_pays = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_pays($bdd, $nom) {
	$sql = "SELECT 1 FROM pays WHERE nom_pays = '".$nom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return NULL !== $reponse->fetch_assoc();

}

function add_pays($bdd, $nom, $devise){
	$sql = "INSERT INTO pays (num_pays, nom_pays, num_dev) VALUES (NULL,'".$nom."','".$devise."')";
	$bdd->query($sql) or die($bdd->error);
	$pays_id = $bdd->insert_id;
	return $pays_id;
}

function update_pays($bdd, $id, $nom, $devise){
	$sql = 'UPDATE pays SET nom_pays = "'.$nom.'", num_dev="' . $devise . '" WHERE num_pays = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}	