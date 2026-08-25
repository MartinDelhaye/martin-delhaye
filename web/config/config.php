<?php

$cheminBdd = __DIR__ . '/../data/database.sqlite';

try {
    $bdd = new PDO("sqlite:$cheminBdd");
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->exec('PRAGMA foreign_keys = ON;'); // à activer à chaque connexion, SQLite ne le fait pas par défaut
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Détection du chemin absolu (avec HTTP ou HTTPS dynamiquement)
$protocole = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$chemin_absolu_site = $protocole . '://' . $_SERVER['HTTP_HOST'];