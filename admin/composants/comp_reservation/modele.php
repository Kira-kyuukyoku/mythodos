<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_reservation($bdd){
	$liste = array();
	$sql = "SELECT reservation.num_res, reservation.num_cli, reservation.prog_cir, reservation.nb_place, reservation.paiement, 
		nom_cli, pren_cli, civ_cli, programme.num_cir, nom_cir, DATE_FORMAT(programme.date_dep,'%d/%m/%Y') AS date_dep
	FROM reservation 
		JOIN client
			ON client.num_cli = reservation.num_cli
		JOIN programme
			ON programme.prog_cir = reservation.prog_cir
		JOIN circuit
			ON programme.num_cir = circuit.num_cir
	ORDER BY num_res DESC";
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

function voir_reservation($bdd, $id){
	$sql = "SELECT reservation.num_res, reservation.num_cli, reservation.prog_cir, reservation.nb_place, reservation.paiement, 
			nom_cli, pren_cli, civ_cli, programme.num_cir, nom_cir, DATE_FORMAT(programme.date_dep,'%d/%m/%Y') AS date_dep 
		FROM reservation 
			JOIN client
				ON client.num_cli = reservation.num_cli
			JOIN programme
				ON programme.prog_cir = reservation.prog_cir
			JOIN circuit
				ON programme.num_cir = circuit.num_cir
		WHERE num_res = ".$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_reservation($bdd, $id){
	$sql = 'DELETE FROM reservation WHERE num_res = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_reservation($bdd, $num_cli, $prog_cir, $prenom){
	$sql = "SELECT 1 FROM reservation WHERE num_cli =  '".$num_cli."' AND prog_cir = '".$prog_cir."' AND pren_voy = '".$prenom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function update_reservation($bdd, $id, $prog_cir){
	$sql = 'UPDATE reservation SET prog_cir = "'.$prog_cir.'" WHERE num_res = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}

function liste_programme($bdd, $num_cir){
	$liste = array();
	$sql = "SELECT prog_cir, DATE_FORMAT(date_dep,'%d/%m/%Y') AS date_dep  FROM programme WHERE num_cir = '".$num_cir."' ORDER BY date_dep DESC";
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