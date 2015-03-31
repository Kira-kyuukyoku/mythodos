<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_pays($bdd){
	$liste = array();
	$sql = "SELECT num_pays, nom_pays FROM pays ORDER BY nom_pays ASC";
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

function circuit_dispo($bdd, $id, $prog_cir){
	$sql = "SELECT (SELECT IFNULL(SUM(res.nb_place), 0) FROM reservation res WHERE res.prog_cir = prog.prog_cir) AS place_reserver, 
				prog.nb_places AS place_dispo 
			FROM programme prog
		WHERE prog.prog_cir = '".$prog_cir."'  ";
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;

}

function recap_circuit($bdd, $id, $prog_cir, $num_cli = 0){
	$sql = "SELECT (SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir ) AS duree_total, 
	(SELECT nom_pays FROM pays WHERE num_pays = ville_d.num_pays ) AS pays_dep, 
	(SELECT num_dev FROM pays WHERE num_pays = ville_d.num_pays ) AS num_dev, 
	
	(SELECT SUM(mon.prix_mon) FROM circuit cir
		JOIN etape eta
			ON eta.num_cir = cir.num_cir
		JOIN monument mon
			ON mon.num_ville = eta.num_ville
	WHERE cir.num_cir = ".$id." AND eta.num_cir = ".$id.") AS prix_mon, 
	
	cir.num_cir, cir.nom_cir, cir.desc_cir, cir.prix_cir, prog.prog_cir, 
	ville_d.img_ville AS img_dep, ville_d.nom_ville AS ville_dep, ville_arr.nom_ville AS ville_arr, 
	DATE_FORMAT(prog.date_dep,'%W %d %M %Y') AS date_dep, STR_TO_DATE(prog.date_dep, '%Y-%m-%d') AS date_dep_unix ";
	
	 
	if(intval($num_cli != 0)){
		$sql .= ", res.nb_place, res.paiement, cli.num_cli, cli.nom_cli, cli.pren_cli, cli.civ_cli, cli.ad_cli, cli.cp_cli, cli.ville_cli, cli.pays_cli, cli.tel_cli, cli.tel2_cli, cli.mail_cli ";
	}
	
		$sql .= "FROM circuit cir 
		JOIN ville ville_d
			ON ville_d.num_ville = cir.ville_dep
		JOIN ville AS ville_arr
			ON ville_arr.num_ville = cir.ville_arr
		JOIN programme prog
			ON prog.num_cir = cir.num_cir ";
			
	if(intval($num_cli != 0)){
		$sql .= "JOIN reservation res 
			ON res.prog_cir = prog.prog_cir
		JOIN client cli
			ON cli.num_cli = res.num_cli";
	}

		$sql .= " WHERE cir.num_cir = ".$id." AND prog.prog_cir = ".$prog_cir;
		
	if(intval($num_cli != 0)){
		$sql .= " AND res.num_cli = ".$num_cli;
	}
	
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function liste_voyageur($bdd, $num_cli){
	$liste = array();
	$sql = "SELECT civ_voy, nom_voy, pren_voy, type_voy, DATE_FORMAT(nais_voy,'%d %M %Y') AS nais_voy FROM voyageur WHERE num_cli = ".$num_cli." ORDER BY nom_voy, pren_voy ASC";
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

function add_client($bdd, $nom_cli, $pren_cli, $civ_cli, $ad_cli, $cp_cli, $ville_cli, $pays_cli, $tel_cli, $tel2_cli, $mail_cli){
	$sql = "INSERT INTO client (num_cli, nom_cli, pren_cli, civ_cli, ad_cli, cp_cli, ville_cli, pays_cli, tel_cli, tel2_cli, mail_cli) 
	VALUES (NULL,'".$nom_cli."','".$pren_cli."','".$civ_cli."','".$ad_cli."','".$cp_cli."','".$ville_cli."','".$pays_cli."','".$tel_cli."','".$tel2_cli."','".$mail_cli."')";
	$bdd->query($sql) or die($bdd->error);
	$num_id = $bdd->insert_id;
	return $num_id;
}

function existe_client_reservation($bdd, $nom, $prenom, $prog_cir){
	$sql = "SELECT 1  
	FROM client cli, reservation res 
	WHERE cli.nom_cli = '".$nom."' AND cli.pren_cli = '".$prenom."' AND res.prog_cir ='".$prog_cir."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_voyageur($bdd, $num_cli, $civ_voy, $nom_voy, $pren_voy, $type_voy, $nais_voy){
	$sql = "INSERT INTO voyageur (num_voy, num_cli, civ_voy, nom_voy, pren_voy, type_voy, nais_voy) 
	VALUES (NULL,'".$num_cli."','".$civ_voy."','".$nom_voy."','".$pren_voy."','".$type_voy."','".$nais_voy."')";
	$bdd->query($sql) or die($bdd->error);
	$num_voy = $bdd->insert_id;
	return $num_voy;
}

function add_reservation($bdd, $num_cli, $prog_cir, $nb_place){
	$sql = "INSERT INTO reservation (num_res, num_cli, prog_cir, nb_place, paiement) 
	VALUES (NULL,'".$num_cli."','".$prog_cir."','".$nb_place."',0)";
	$bdd->query($sql) or die($bdd->error);
	$num_res = $bdd->insert_id;
	return $num_res;
}

function update_reservation($bdd, $num_res){
	$sql = 'UPDATE reservation SET paiement = 1 WHERE num_res = '.$num_res;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}	

function prix_paiement($bdd, $id, $prog_cir){
	$sql = "SELECT (SELECT num_dev FROM pays WHERE num_pays = ville_d.num_pays ) AS num_dev, 
	(SELECT SUM(mon.prix_mon) FROM circuit cir 
		JOIN etape eta 
			ON eta.num_cir = cir.num_cir 
		JOIN monument mon 
			ON mon.num_ville = eta.num_ville 
		WHERE cir.num_cir = ".$id." AND eta.num_cir = ".$id.") AS prix_mon, 
	cir.num_cir, cir.prix_cir, prog.prog_cir 
		FROM circuit cir 
		JOIN ville ville_d
			ON ville_d.num_ville = cir.ville_dep
		JOIN programme prog
			ON prog.num_cir = cir.num_cir 
		WHERE cir.num_cir = ".$id." AND prog.prog_cir = ".$prog_cir;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}