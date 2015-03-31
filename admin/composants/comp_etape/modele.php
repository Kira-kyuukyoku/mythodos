<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_etape($bdd, $page=1, $pagination=MAX_ITEM_PAR_PAGE){
	$liste = array();
	
    // Numéro du 1er enregistrement à lire
    $limite_debut = ($page - 1) * $pagination;
	
	$sql = "SELECT (SELECT COUNT(num_eta) FROM etape) AS nb_total, etape.num_eta, etape.num_ville, etape.num_cir, ville.nom_ville, circuit.nom_cir FROM etape 
	JOIN ville 
        ON ville.num_ville = etape.num_ville
	JOIN circuit 
        ON circuit.num_cir = etape.num_cir
	ORDER BY num_cir, num_eta ASC LIMIT ".$limite_debut.','.$pagination;
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

function voir_etape($bdd, $num_eta, $num_cir){
	$sql = 'SELECT num_eta, desc_eta, dur_eta, num_ville, num_cir FROM etape WHERE num_eta = "'.$num_eta.'" AND num_cir = "'.$num_cir.'"';
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_etape($bdd, $num_eta, $num_cir){
	$sql = 'DELETE FROM etape WHERE num_eta = "'.$num_eta.'" AND num_cir = "'.$num_cir;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_etape($bdd, $num_eta, $num_cir){
	$sql = "SELECT 1 FROM etape WHERE num_eta = '".$num_eta."' AND num_cir = '".$num_cir."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_etape($bdd, $num_eta, $desc, $duree, $ville, $circuit){
	$sql = "INSERT INTO etape (num_eta, desc_eta, dur_eta, num_ville, num_cir) 
		VALUES ('".$num_eta."','".$desc."','".$duree."','".$ville."','".$circuit."')";
	$bdd->query($sql) or die($bdd->error);
	$etape_id = $bdd->insert_id;
	return $etape_id;
}

function update_etape($bdd, $num_eta, $desc, $duree, $ville, $circuit, $old_eta, $old_cir){
	$sql = 'UPDATE etape SET num_eta = "'.$num_eta.'", desc_eta =  "'.$desc.'", dur_eta="' . $duree . '", num_ville = "'.$ville.'", num_cir = "'.$circuit.'" WHERE num_eta = "'.$old_eta.'" AND num_cir = "'.$old_cir.'"';
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}

function liste_ville($bdd){
	$liste = array();
	$sql = "SELECT num_ville, nom_ville, ville.num_pays, nom_pays FROM ville 
	JOIN pays
		ON pays.num_pays = ville.num_pays
	ORDER BY nom_pays, nom_ville ASC ";
	$reponse = mysqli_query($bdd, $sql) or die(mysqli_error); 
	if(mysqli_num_rows($reponse) != 0) {
        while ($data = mysqli_fetch_assoc($reponse))
        {
                $liste[] = $data;
		}
	}
		mysqli_free_result($reponse);
 
	return $liste;
}

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