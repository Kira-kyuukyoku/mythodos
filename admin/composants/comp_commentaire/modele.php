<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_commentaire($bdd){
	$liste = array();
	$sql = "SELECT num_com, pseudo_com, DATE_FORMAT(date_com,'%d-%m-%Y') AS date_com, circuit.nom_cir FROM commentaire 
		JOIN circuit 
        ON circuit.num_cir = commentaire.num_cir
	ORDER BY num_com DESC";
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

function voir_commentaire($bdd, $id){
	$sql = 'SELECT num_com, pseudo_com, mess_com FROM commentaire WHERE num_com = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_commentaire($bdd, $id){
	$sql = 'DELETE FROM commentaire WHERE num_com = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function update_commentaire($bdd, $id, $nom, $mess){
	$sql = 'UPDATE commentaire SET num_com = "'.$id.'", pseudo_com = "'.$nom.'", mess_com="' . $mess . '" WHERE num_com = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}