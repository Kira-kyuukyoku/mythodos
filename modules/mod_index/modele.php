<?php 
function liste_banniere($bdd){
	$liste = array();
	$sql = "SELECT num_ban, nom_ban, img_ban, desc_ban, num_cir FROM banniere ORDER BY RAND() ASC LIMIT 3";
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
