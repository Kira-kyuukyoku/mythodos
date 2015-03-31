<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_circuit($bdd, $destination, $etape, $duree, $date_dep, $prix_min = 0, $prix_max = 0){
	$liste = array();
	$choix = array();
	$first = true;
	$where = '';
	
	$sql = "SELECT 
	(SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir ) AS duree_total, 
	(SELECT num_dev FROM pays WHERE num_pays = ville_dep.num_pays ) AS num_dev, 
	(SELECT nom_pays FROM pays WHERE num_pays = ville_arr.num_pays ) AS pays_dep, 
	(SELECT nom_pays FROM pays WHERE num_pays = ville_arr.num_pays ) AS pays_arr, 
	
(SELECT DATE_FORMAT(prog.date_dep,'%d/%m/%Y') FROM programme prog WHERE prog.num_cir = cir.num_cir AND date_dep >= CURRENT_DATE ORDER BY ABS (DATEDIFF (UTC_DATE(), prog.date_dep)) LIMIT 1 ) AS date_dep, 
		
	cir.num_cir, cir.nom_cir, cir.desc_cir, cir.prix_cir, 
	ville_dep.nom_ville AS ville_dep, ville_arr.nom_ville AS ville_arr, ville.img_ville AS ville_etape, ville.nom_ville AS nom_ville_etape 

		FROM circuit cir 
		JOIN ville AS ville_dep
			ON ville_dep.num_ville = cir.ville_dep
		JOIN ville AS ville_arr
			ON ville_arr.num_ville = cir.ville_arr
		JOIN etape 
			ON etape.num_cir = cir.num_cir AND etape.num_eta = 1
		JOIN ville 
			ON ville.num_ville = etape.num_ville";
		
	if($destination !=0){
		$sql .= " JOIN etape eta
				ON eta.num_cir = cir.num_cir 
					JOIN ville AS ville_eta
				ON ville_eta.num_ville = eta.num_ville
					JOIN pays pays
				ON pays.num_pays = ville_eta.num_pays
				";
		$choix[] = " pays.num_pays = ".$destination;
		}
		
	if($etape !=0){
		$sql .= " JOIN etape rech_eta 
				ON rech_eta.num_cir = cir.num_cir 
					JOIN ville AS rech_ville 
				ON rech_ville.num_ville = rech_eta.num_ville";
		$choix[] = " rech_eta.num_ville = ".$etape." AND rech_ville.num_ville = ".$etape;
		}
		
	if($duree !=0){
		if($duree == 1){
			$choix[] = " (SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir ) <= 6 ";
		}
		if($duree == 2){
			$choix[] = " (SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir )>= 7 AND (SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir ) <= 11 ";
		}
		if($duree == 3){
			$choix[] = " (SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir ) >= 12 ";
		}
	}
	
	if($date_dep !=0){
		$sql .= " JOIN programme prog 
				ON prog.num_cir = cir.num_cir ";
		$choix[] = " prog.prog_cir = ".$date_dep;
		}
		
	if($prix_min !=0){
		$choix[] = " cir.prix_cir >= ".$prix_min;
		}
		
	if($prix_max !=0){
		$choix[] = " cir.prix_cir <= ".$prix_max;
		}
		  
		foreach($choix as $c)
		{
			// si c'est la premiere condition, on met WHERE, sinon on met AND
			if ($first)
			{
				$first = false;
				$where .= " WHERE $c ";
			}
			else
			{
				$where .= " AND $c ";
			}
		}

		$sql .= $where . " GROUP BY cir.num_cir ORDER BY cir.nom_cir DESC";
		
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

function liste_date_depart($bdd, $id){
	$liste = array();
	$sql = "SELECT prog.prog_cir, DATE_FORMAT(prog.date_dep,'%d/%m/%Y') AS date_dep, prog.nb_places, prog.num_cir 
	FROM programme prog
	WHERE prog.date_dep >= CURRENT_DATE AND prog.num_cir = ".$id."
	ORDER BY date_dep DESC";
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


function liste_etape($bdd, $id){
	$liste = array();
	$sql = "SELECT eta.num_eta, eta.desc_eta, eta.dur_eta, ville.nom_ville  
	FROM etape eta
		JOIN ville 
			ON ville.num_ville = eta.num_ville
	WHERE eta.num_cir = ".$id."
	ORDER BY eta.num_eta ASC";
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

function voir_circuit($bdd, $id){
	$sql = "SELECT 
	(SELECT SUM(dur_eta) FROM etape WHERE etape.num_cir = cir.num_cir ) AS duree_total, 
	(SELECT nom_pays FROM pays WHERE num_pays = ville_d.num_pays ) AS pays_dep, 
	(SELECT num_dev FROM pays WHERE num_pays = ville_d.num_pays ) AS num_dev, 
	(SELECT nom_pays FROM pays WHERE num_pays = ville_arr.num_pays ) AS pays_arr,
	(SELECT DATE_FORMAT(prog.date_dep,'%d/%m/%Y') FROM programme prog WHERE prog.num_cir = cir.num_cir AND date_dep >= CURRENT_DATE ORDER BY ABS (DATEDIFF (UTC_DATE(), prog.date_dep)) LIMIT 1 ) AS date_dep, 	
	cir.num_cir, cir.nom_cir, cir.desc_cir, cir.prix_cir, 
	ville_d.img_ville AS img_dep, ville_arr.img_ville AS img_arr, ville_d.nom_ville AS ville_dep, ville_arr.nom_ville AS ville_arr, 
	
	(SELECT GROUP_CONCAT(DISTINCT(ville.img_ville) SEPARATOR ',')  
		FROM etape eta
			JOIN ville
				ON ville.num_ville = eta.num_ville
	WHERE eta.num_cir = cir.num_cir ) AS img_ville
	
		FROM circuit cir 
		JOIN ville ville_d
			ON ville_d.num_ville = cir.ville_dep
		JOIN ville AS ville_arr
			ON ville_arr.num_ville = cir.ville_arr

		WHERE cir.num_cir = ".$id." 
		ORDER BY cir.nom_cir DESC";
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}


function liste_comment($bdd, $id){
	$liste = array();
	$sql = "SELECT com.num_com, com.pseudo_com, com.mess_com, DATE_FORMAT(com.date_com,'%d/%m/%Y') AS date_com
	FROM commentaire com
	WHERE com.num_cir = ".$id."
	ORDER BY com.date_com ASC";
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

function add_comment($bdd, $pseudo, $comment, $num_cir){
	$sql = "INSERT INTO commentaire (num_com, pseudo_com, mess_com, date_com, num_cir) VALUES (NULL,'".$pseudo."','".$comment."',NOW(),'".$num_cir."')";
	$bdd->query($sql) or die($bdd->error);
	$com_id = $bdd->insert_id;
	return $com_id;
}