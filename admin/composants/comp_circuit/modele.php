<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_circuit($bdd){
	$liste = array();
	$sql = "SELECT num_cir, nom_cir, ville_dep, ville_arr FROM circuit ORDER BY num_cir DESC";
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

function voir_circuit($bdd, $id){
	$sql = 'SELECT num_cir, nom_cir, desc_cir, prix_cir, ville_dep, ville_arr FROM circuit WHERE num_cir = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_circuit($bdd, $id){
	$sql = 'DELETE FROM circuit WHERE num_cir = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_circuit($bdd, $nom){
	$sql = "SELECT 1 FROM circuit WHERE nom_cir = '".$nom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_circuit($bdd, $nom, $desc, $prix, $ville_dep, $ville_arr){
	$sql = "INSERT INTO circuit (num_cir, nom_cir, desc_cir, prix_cir, ville_dep, ville_arr) 
		VALUES (NULL,'".$nom."','".$desc."','".$prix."','".$ville_dep."','".$ville_arr."')";
	$bdd->query($sql) or die($bdd->error);
	$circuit_id = $bdd->insert_id;
	return $circuit_id;
}

function update_circuit($bdd, $id, $nom, $desc, $prix, $ville_dep, $ville_arr){
	$sql = 'UPDATE circuit SET num_cir = "'.$id.'", nom_cir = "'.$nom.'", desc_cir =  "'.$desc.'", prix_cir="' . $prix . '", ville_dep = "'.$ville_dep.'", ville_arr = "'.$ville_arr.'" WHERE num_cir = '.$id;
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