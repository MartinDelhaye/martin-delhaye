<?php

// Connexion à la base de données
$hote = 'db'; // correspond au service MySQL dans docker-compose
$port = '3306';
$nom_bd = 'mdportfolio';
$identifiant = 'docker';
$mot_de_passe = 'docker';
$encodage = 'utf8';

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $encodage);

try {
    $bdd = new PDO(
        "mysql:host=$hote;port=$port;dbname=$nom_bd",
        $identifiant,
        $mot_de_passe,
        $options
    );
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Détection du chemin absolu (avec HTTP ou HTTPS dynamiquement)
$protocole = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$chemin_absolu_site = $protocole . '://' . $_SERVER['HTTP_HOST'];
