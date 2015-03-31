<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_monument($bdd){
	$liste = array();
	$sql = "SELECT num_mon, nom_mon, prix_mon, num_ville FROM monument ORDER BY num_mon DESC";
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

function voir_monument($bdd, $id){
	$sql = 'SELECT num_mon, nom_mon, prix_mon, num_ville FROM monument WHERE num_mon = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_monument($bdd, $id){
	$sql = 'DELETE FROM monument WHERE num_mon = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_monument($bdd, $nom){
	$sql = "SELECT 1 FROM monument WHERE nom_mon = '".$nom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_monument($bdd, $nom, $prix, $num_ville){
	$sql = "INSERT INTO monument (num_mon, nom_mon, prix_mon, num_ville) VALUES (NULL,'".$nom."','".$prix."','".$num_ville."')";
	$bdd->query($sql) or die($bdd->error);
	$monument_id = $bdd->insert_id;
	return $monument_id;
}

function update_monument($bdd, $id, $nom, $prix, $num_ville){
	$sql = 'UPDATE monument SET num_mon = "'.$id.'", nom_mon = "'.$nom.'", prix_mon="' . $prix . '", num_ville = "'.$num_ville.'" WHERE num_mon = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}

function liste_ville($bdd){
	$liste = array();
	$sql = "SELECT num_ville, nom_ville, ville.num_pays, nom_pays FROM ville 
	JOIN pays
		ON pays.num_pays = ville.num_pays
	ORDER BY nom_pays, nom_ville ASC ";
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