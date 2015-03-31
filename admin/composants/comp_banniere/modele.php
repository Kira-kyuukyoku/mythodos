<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_banniere($bdd){
	$liste = array();
	$sql = "SELECT num_ban, nom_ban, img_ban, desc_ban, num_cir FROM banniere ORDER BY num_ban DESC";
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

function voir_banniere($bdd, $id){
	$sql = 'SELECT num_ban, nom_ban, img_ban, desc_ban, num_cir FROM banniere WHERE num_ban = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_banniere($bdd, $id){
	$sql = 'DELETE FROM banniere WHERE num_ban = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_banniere($bdd, $nom){
	$sql = "SELECT 1 FROM banniere WHERE nom_ban = '".$nom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_banniere($bdd, $nom, $img, $desc, $num_cir){
	$sql = "INSERT INTO banniere (num_ban, nom_ban, img_ban, desc_ban, num_cir) VALUES (NULL,'".$nom."','".$img."','".$desc."','".$num_cir."')";
	$bdd->query($sql) or die($bdd->error);
	$ban_id = $bdd->insert_id;
	return $ban_id;
}

function update_banniere($bdd, $id, $nom, $img = '', $desc, $num_cir){
	$sql = 'UPDATE banniere SET num_ban = "'.$id.'", nom_ban = "'.$nom.'", img_ban="' . $img . '", desc_ban="' . $desc . '", num_cir = "'.$num_cir.'" WHERE num_ban = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}

function liste_circuit($bdd){
	$liste = array();
	$sql = "SELECT num_cir, nom_cir FROM circuit ORDER BY num_cir DESC";
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