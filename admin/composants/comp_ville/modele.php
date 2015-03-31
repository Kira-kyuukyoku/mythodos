<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_ville($bdd, $page=1, $pagination=MAX_ITEM_PAR_PAGE){
	$liste = array();
	
    // Numéro du 1er enregistrement à lire
    $limite_debut = ($page - 1) * $pagination;
		
	$sql = 'SELECT (SELECT COUNT(num_ville) FROM ville) AS nb_total, num_ville, nom_ville, img_ville, num_pays 
	FROM ville ORDER BY num_ville DESC LIMIT '.$limite_debut.','.$pagination;
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

function voir_ville($bdd, $id){
	$sql = 'SELECT num_ville, nom_ville, img_ville, num_pays FROM ville WHERE num_ville = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_ville($bdd, $id){
	$sql = 'DELETE FROM ville WHERE num_ville = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_ville($bdd, $nom){
	$sql = "SELECT 1 FROM ville WHERE nom_ville = '".$nom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return NULL !== $reponse->fetch_assoc();
}

function add_ville($bdd, $nom, $img, $num_pays){
	$sql = "INSERT INTO ville (num_ville, nom_ville, img_ville, num_pays) VALUES (NULL,'".$nom."','".$img."','".$num_pays."')";
	$bdd->query($sql) or die($bdd->error);
	$ville_id = $bdd->insert_id;
	return $ville_id;
}

function update_ville($bdd, $id, $nom, $img = '', $num_pays){
	$sql = 'UPDATE ville SET num_ville = "'.$id.'", nom_ville = "'.$nom.'", img_ville="' . $img . '", num_pays = "'.$num_pays.'" WHERE num_ville = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
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