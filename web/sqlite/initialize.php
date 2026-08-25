<?php

require __DIR__ . '/../vendor/autoload.php';

$pdo = new \PDO('sqlite:' . __DIR__ . '/../data/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON;');

// Crée la table competences
$sql = "
CREATE TABLE IF NOT EXISTS competences (
    id_competence INTEGER PRIMARY KEY AUTOINCREMENT,
    nom_competence TEXT NOT NULL,
    image_competence TEXT,
    type_competence TEXT NOT NULL,
    parent_id INTEGER REFERENCES competences(id_competence) ON DELETE SET NULL,
    description TEXT
)";
$pdo->exec($sql);

// Crée la table projets
$sql = "
CREATE TABLE IF NOT EXISTS projets (
    id_projet INTEGER PRIMARY KEY AUTOINCREMENT,
    titre_projet TEXT NOT NULL,
    texte_projet TEXT NOT NULL,
    date_projet DATE,
    url_projet TEXT,
    urlGitHub_projet TEXT,
    illustration_projet TEXT
)";
$pdo->exec($sql);

// Crée la table images_projet
$sql = "
CREATE TABLE IF NOT EXISTS images_projet (
    id_image INTEGER PRIMARY KEY AUTOINCREMENT,
    id_projet INTEGER REFERENCES projets(id_projet) ON DELETE CASCADE,
    url_image TEXT NOT NULL
)";
$pdo->exec($sql);

echo "Base SQLite initialisée ✅\n";