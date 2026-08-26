<?php

require __DIR__ . '/../vendor/autoload.php';

$pdo = new \PDO('sqlite:' . __DIR__ . '/../data/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = ON;');

// Pattern idempotent : on ne seed que si la table projets est vide,
// pour éviter de dupliquer les données à chaque exécution.
$dejaRempli = (int) $pdo->query('SELECT COUNT(*) FROM projets')->fetchColumn() > 0;

if ($dejaRempli) {
    echo "Données déjà présentes, seed ignoré.\n";
    exit;
}

// --- competences ---
// (id, nom, image, type, parent_id)
$competences = [
    [1, "PHP", "images/competences/logo-PHP.png", "Langage", null],
    [2, "SQL", "images/competences/logo-SQL.png", "Langage", null],
    [3, "HTML", "images/competences/logo-HTML.png", "Langage", null],
    [4, "CSS", "images/competences/logo-CSS.png", "Langage", null],
    [5, "JavaScript", "images/competences/logo-JavaScript.png", "Langage", null],
    [6, "Python", "images/competences/logo-Python.png", "Langage", null],
    [7, "Snap.js", "images/competences/logo-Snap.svg", "Librairie", 5],
    [8, "GSAP", "images/competences/logo-GSAP.jpg", "Librairie", 5],
    [9, "WordPress", "images/competences/logo-WordPress.png", "CMS", null],
    [10, "Visual Studio Code", "images/competences/logo-Visual_Studio_Code.png", "Logiciel", null],
    [11, "MySQL", "images/competences/logo-MySQL.png", "Logiciel", null],
    [12, "Figma", "images/competences/logo-Figma.svg", "Logiciel", null],
    [13, "InDesign", "images/competences/logo-InDesign.png", "Logiciel", null],
    [14, "Illustrator", "images/competences/logo-Illustrator.png", "Logiciel", null],
    [15, "Photoshop", "images/competences/logo-Photoshop.png", "Logiciel", null],
    [16, "Symfony", "images/competences/logo-Symfony.png", "Librairie", 1],
    [17, "Twig", "images/competences/logo-Twig.png", "Librairie", 1],
    [20, "THREE.JS", "images/competences/logo-THREE.JS.png", "Librairie", 5],
    [21, "React", "images/competences/logo-React.png", "Framework", 5],
    [22, "Next.js", "images/competences/logo-Next.js.png", "Framework", 21],
    [23, "Ammo.js", "images/competences/logo-Ammo.js.png", "Librairie", 20],
];

$insertCompetence = $pdo->prepare(
    "INSERT INTO competences (id_competence, nom_competence, image_competence, type_competence, parent_id, description)
     VALUES (?, ?, ?, ?, ?, NULL)"
);
foreach ($competences as $c) {
    $insertCompetence->execute($c);
}

// --- projets ---
// (id, titre, texte, date, url, github, illustration)
$projets = [
    [
        1,
        "Site | MaMusique",
        "J'ai conçu un site web pour présenter mes musiques, albums, groupes et artistes favoris.\n" .
        "C'est mon premier projet intégrant une base de données, avec une page d'administration pour gérer les contenus.\n" .
        "La BDD a été modélisée via un schéma relationnel et un modèle entité-association.\n" .
        "Côté front-end, j'ai développé sans librairies externes un carrousel, des filtres, des pop-ups interactives et un changement de thème via variables CSS.",
        "2024-04-05",
        "https://mamusique.martin-delhaye.fr",
        "https://github.com/MartinDelhaye/Mamusique",
        "images/Projets/MaMusique/illustration-MaMusique.png",
    ],
    [
        2,
        "Site | Tonnerre 2 Zeus",
        "Tonnerre 2 Zeus est mon premier site statique destiné à présenter l'attraction éponyme.\n" .
        "J'ai conçu un wireframe avec Figma et veillé à produire un code clair, commenté et validé par le W3C.\n" .
        "Une fonctionnalité en PHP enregistre les données d'un formulaire dans un fichier texte et les affiche sous forme de statistiques.\n" .
        "Ce projet m'a permis de découvrir les bases du développement web, avec HTML, CSS, PHP et mes premiers pas en JavaScript.",
        "2023-12-08",
        "https://tonnerre2zeus.martin-delhaye.fr",
        "https://github.com/MartinDelhaye/Tonnerre_2_Zeus",
        "images/Projets/Site Tonnerre 2 Zeus/illustration-Site Tonnerre 2 Zeus.png",
    ],
    [
        3,
        "Site | TheGuardian",
        "J'ai développé un site web interactif pour visualiser les données de mobilité électrique dans le Pas-de-Calais.\n" .
        "Il intègre des graphiques animés grâce à GSAP et des interactions dynamiques avec Snap.js.\n" .
        "Les fichiers SVG ont été structurés avec des ID uniques pour cibler précisément chaque élément graphique.\n" .
        "Un effet de surbrillance au survol améliore la compréhension des tendances des données.",
        "2024-10-02",
        "https://martindelhaye.github.io/SAE303.2",
        "https://github.com/MartinDelhaye/SAE303.2",
        "images/Projets/TheGuardian/illustration-TheQuardian.png",
    ],
    [
        4,
        "Site | AD Personal Training",
        "Il s'agit de ma première expérience professionnelle. Effectivement Arnaud Deshamps, un coach sportif, m'a confié la tâche de réaliser son site. " .
        "Il s'agit d'un site vitrine dynamique. Une page d'administration permet à Arnaud de modifier tout le contenu de son site que ça soit les titres, textes, images, ordre d'élément sur certaines pages, etc...",
        "2025-01-12",
        "https://adpersonaltraining.fr",
        null,
        "images/Projets/Site ADPT/illustration-Site-ADPT.png",
    ],
    [
        5,
        "Jeu | TwoSeeToSee",
        "TwoSeeToSee est un petit jeu développé en 4j avec THREE.js pour la 3D et Ammo.js pour la physique.\n" .
        "Inspiré de Super Paper Mario, il intègre une mécanique de double caméra permettant de basculer entre vues 2D et 3D.\n" .
        "Le style cartoon a été choisi pour gagner du temps tout en gardant un rendu clair et attractif.\n" .
        "Le jeu propose actuellement 3 niveaux, générés à partir de fichiers JSON définissant les plateformes.",
        "2025-04-04",
        "https://twoseetosee.martin-delhaye.fr/",
        "https://gitlab.com/sae402-twoseetosee/twoseetosee-dev",
        "images/Projets/TwoSeeToSee/illustration-TwoSeeToSee.png",
    ],
];

$insertProjet = $pdo->prepare(
    "INSERT INTO projets (id_projet, titre_projet, texte_projet, date_projet, url_projet, urlGitHub_projet, illustration_projet)
     VALUES (?, ?, ?, ?, ?, ?, ?)"
);
foreach ($projets as $p) {
    $insertProjet->execute($p);
}

// --- images_projet ---
// (id, id_projet, url_image)
$imagesProjet = [
    [1, 1, "images/Projets/MaMusique/carrousel-1.png"],
    [2, 1, "images/Projets/MaMusique/carrousel-2.png"],
    [3, 5, "images/Projets/TwoSeeToSee/2.png"],
    [4, 5, "images/Projets/TwoSeeToSee/3.png"],
    [5, 5, "images/Projets/TwoSeeToSee/5.png"],
    [6, 5, "images/Projets/TwoSeeToSee/7.png"],
    [7, 5, "images/Projets/TwoSeeToSee/9.png"],
];

$insertImage = $pdo->prepare(
    "INSERT INTO images_projet (id_image, id_projet, url_image) VALUES (?, ?, ?)"
);
foreach ($imagesProjet as $img) {
    $insertImage->execute($img);
}

// --- projet_competence ---
// Associations proposées par déduction des descriptions de projets.
// À AJUSTER : c'est une estimation, pas une vérité issue de la base.
// (id_projet, id_competence)
$projetCompetence = [
    // MaMusique : PHP + MySQL (BDD relationnelle + admin), HTML/CSS/JS sans librairie
    [1, 1], [1, 11], [1, 3], [1, 4], [1, 5],
    // Tonnerre 2 Zeus : site statique HTML/CSS/PHP/JS, wireframe Figma
    [2, 3], [2, 4], [2, 1], [2, 5], [2, 12],
    // TheGuardian : dataviz avec GSAP + Snap.js (toutes deux enfants de JavaScript)
    [3, 5], [3, 8], [3, 7], [3, 3], [3, 4],
    // AD Personal Training : site vitrine dynamique avec admin, PHP + MySQL
    [4, 1], [4, 11], [4, 3], [4, 4], [4, 5],
    // TwoSeeToSee : jeu THREE.js + Ammo.js (toutes deux enfants de JavaScript)
    [5, 5], [5, 20], [5, 23],
];

$insertLien = $pdo->prepare(
    "INSERT INTO projet_competence (id_projet, id_competence) VALUES (?, ?)"
);
foreach ($projetCompetence as $lien) {
    $insertLien->execute($lien);
}

echo "Données du portfolio importées ✅\n";
