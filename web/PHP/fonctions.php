<?php

function obtenirDonnees($info, $table, $filtre = '', $trier = '', $type_fetch = 'fetchAll') {
    global $bdd;
    try {
        $requete = 'SELECT ' . $info . ' FROM ' . $table;
        if (!empty($filtre)) {
            $requete .= ' WHERE ' . $filtre;
        }
        if (!empty($trier)) {
            $requete .= ' ORDER BY ' . $trier;
        }
        
        $stmt = $bdd->query($requete);
        return $stmt->$type_fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $requete."<br>";
        die('Erreur : ' . $e->getMessage());
    }
}

function infoMeta() {
    echo '
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="Martin Delhaye">
    
    <link rel="apple-touch-icon" sizes="180x180" href="apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-16x16.png">
    <link rel="manifest" href="site.webmanifest">
    
    <link rel="stylesheet" href="https://use.typekit.net/tlw3ues.css">
    
    <link rel="stylesheet" href="CSS/style.css">
    
    <script src="JS/scripts.js" defer></script>';
}


function afficherImage($url_image, $title_alt, $class = "", $id = "", $paramSup = ""){
    if($class != "") $class = ' class="' . $class . '"'; 
    if($id != "") $id = ' id="' . $id . '"'; 

    return '<img src="' . $url_image . '" alt="' . $title_alt . '" title="' . $title_alt . '"' . $class . $id . ' ' . $paramSup . ' />';
}



function afficherCompetence($nomCompetence, $imageCompetence){
    $imageCompetence ? $image = afficherImage($imageCompetence, "Logo de ".$nomCompetence, 'icon-small') : $image = '';
    return '<article class="border-rond fond-black flex row align-items-center gap-small padding-small"> ' . $image . '<p>' . $nomCompetence . '</p></article>';
}

function afficherProjet($id, $titre, $illustration, $date){
    $illustration ? $image = afficherImage($illustration, "Illustration de ".$titre, 'width-100') : $image = '';
    return '<a href="projet.php?id_projet=' . $id . '" class="width-33 width-70-mobile"><article class="projets button flex column align-items-center gap-small padding-small"> ' . 
                $image . '
                <h3>' . $titre . '</h3>
                <p class="date">' . $date . '</p>
            </article></a>';
}