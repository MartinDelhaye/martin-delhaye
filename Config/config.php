<?php

    // Connexion a la bdd
    $hote='localhost';
    $port='3306';
    $nom_bd='portfolio_md';
    $identifiant='root';
    $mot_de_passe='';
    $encodage='utf8';
    $options=array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES '.$encodage);
    $bdd = new PDO('mysql:host='.$hote.';port='.$port.';dbname='.$nom_bd,$identifiant, $mot_de_passe,$options);


    // Chemin absolu site 
    $chemin_absolu_site = "C:/xampp/htdocs/martin-delhaye";

    include($chemin_absolu_site."/PHP/fonctions.php");
?>