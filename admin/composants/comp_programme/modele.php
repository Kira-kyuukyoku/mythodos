<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_programme($bdd){
	$liste = array();
	$sql = "SELECT prog.prog_cir, DATE_FORMAT(prog.date_dep,'%d/%m/%Y') AS date_dep, prog.nb_places, prog.num_cir, circuit.nom_cir FROM programme AS prog
	JOIN circuit 
        ON circuit.num_cir = prog.num_cir
	ORDER BY prog_cir DESC";
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

function voir_programme($bdd, $id){
	$sql = "SELECT prog_cir, DATE_FORMAT(date_dep,'%d-%m-%Y') AS date_dep, nb_places, num_cir FROM programme WHERE prog_cir = ".$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_programme($bdd, $id){
	$sql = 'DELETE FROM programme WHERE prog_cir = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_programme($bdd, $id){
	$sql = "SELECT 1 FROM programme WHERE prog_cir = '".$id."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_programme($bdd, $date, $nb_place, $num_cir){
	$sql = "INSERT INTO programme (prog_cir, date_dep, nb_places, num_cir) VALUES (NULL,'".$date."','".$nb_place."','".$num_cir."')";
	$bdd->query($sql) or die($bdd->error);
	$prog_id = $bdd->insert_id;
	return $prog_id;
}

function update_programme($bdd, $id, $date, $nb_place, $num_cir){
	$sql = 'UPDATE programme SET prog_cir = "'.$id.'", date_dep = "'.$date.'", nb_places="' . $nb_place . '", num_cir = "'.$num_cir.'" WHERE prog_cir = '.$id;
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