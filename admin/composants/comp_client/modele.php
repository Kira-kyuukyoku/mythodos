<?php
// Pas d'accès direct
if(!defined('INDEX')) exit('Accès interdit');

function liste_client($bdd){
	$liste = array();
	$sql = "SELECT num_cli, nom_cli, pren_cli, civ_cli FROM client ORDER BY num_cli DESC";
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

function voir_client($bdd, $id){
	$sql = 'SELECT * FROM client WHERE num_cli = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	$donnees = $reponse->fetch_assoc();
	return $donnees;
}

function supp_client($bdd, $id){
	$sql = 'DELETE FROM client WHERE num_cli = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return ($reponse === false) ? false : true;
}

function existe_client($nom, $prenom){
	$sql = "SELECT 1 FROM client WHERE nom_cli = '".$nom."' AND pren_cli = '".$prenom."' LIMIT 1";
	$reponse = $bdd->query($sql);
	return ( $reponse->fetch_assoc() != 0 ) ? true : false;
}

function add_client($bdd, $nom, $prenom, $civ, $adr, $cp, $ville, $pays, $tel, $tel2, $mail){
	$sql = "INSERT INTO client (num_cli, nom_cli, pren_cli, civ_cli, ad_cli, cp_cli, ville_cli, pays_cli, tel_cli, tel2_cli, mail_cli) 
	VALUES (NULL, '".$nom."', '".$prenom."', '".$civ."', '".$adr."', '".$cp."', '".$ville."', '".$pays."', '".$tel."', '".$tel2."', '".$mail."')";
	$bdd->query($sql) or die($bdd->error);
	$client_id = $bdd->insert_id;
	return $client_id;
}

function update_client($bdd, $id, $nom, $prenom, $civ, $adr, $cp, $ville, $pays, $tel, $tel2, $mail){
	$sql = 'UPDATE client SET nom_cli = "'.$nom.'", pren_cli="' . $prenom . '", civ_cli = "'.$civ.'", 
	ad_cli="' . $adr . '", cp_cli = "'.$cp.'", ville_cli="' . $ville . '", pays_cli = "'.$pays.'", 
	tel_cli="' . $tel . '", tel2_cli = "'.$tel2.'", mail_cli = "'.$mail.'" 
	WHERE num_cli = '.$id;
	$reponse = $bdd->query($sql) or die($bdd->error);
	return (!$reponse) ? false : true;
}	