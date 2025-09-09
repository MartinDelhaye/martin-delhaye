<?php
include '../config/config.php';
include "fonctions.php";

$donnees = array();

//Vérifier si on a bien les param
if (isset($_GET["id_projet"])) {
    $id_projet = (int) $_GET["id_projet"]; // sécurisation
    $donnees["projet"] = obtenirDonnees(
        'id_projet, titre_projet, url_projet, urlGitHub_projet, texte_projet, date_projet, illustration_projet',
        'projets',
        'id_projet = '.$id_projet,
        type_fetch:'fetch'

    );
    if(!empty($donnees["projet"])) {
        $donnees["statut"] = "ok";
        $donnees["projet"]["images"] = obtenirDonnees(
            'url_image',
            'images_projet',
            'id_projet = '.$id_projet
        );
    } else {    
        $donnees["erreur"] = "Projet non trouvé";
        $donnees["statut"] = "erreur";
    }   
}

// Encodage de la réponse en JSON et affichage
header('Content-Type: application/json');
$donneesJson = json_encode($donnees);
// $donneesJson = str_replace("\\n", " ", $donneesJson);
echo $donneesJson;
