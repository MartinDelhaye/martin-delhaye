<?php

require __DIR__ . '/../vendor/autoload.php';

$pdo = new \PDO('sqlite:' . __DIR__ . '/../data/database.sqlite');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->exec('PRAGMA foreign_keys = OFF;'); // le temps de la migration, réactivé à la fin

function colonneExiste(PDO $pdo, string $table, string $colonne): bool
{
    $stmt = $pdo->query("PRAGMA table_info($table)");
    foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $col) {
        if ($col['name'] === $colonne) {
            return true;
        }
    }
    return false;
}

$pdo->beginTransaction();

try {
    // --- competences : suppression de la hiérarchie parent/enfant ---
    if (colonneExiste($pdo, 'competences', 'parent_id')) {
        $pdo->exec('ALTER TABLE competences DROP COLUMN parent_id');
        echo "→ competences.parent_id supprimée\n";
    } else {
        echo "→ competences.parent_id déjà absente, rien à faire\n";
    }

    // --- projets : date_projet (DATE) → annee_projet (INTEGER) ---
    if (!colonneExiste($pdo, 'projets', 'annee_projet')) {
        $pdo->exec('ALTER TABLE projets ADD COLUMN annee_projet INTEGER');
        $pdo->exec("UPDATE projets SET annee_projet = CAST(strftime('%Y', date_projet) AS INTEGER) WHERE date_projet IS NOT NULL");
        echo "→ projets.annee_projet créée et remplie depuis date_projet\n";
    } else {
        echo "→ projets.annee_projet déjà présente, rien à faire\n";
    }

    if (colonneExiste($pdo, 'projets', 'date_projet')) {
        $pdo->exec('ALTER TABLE projets DROP COLUMN date_projet');
        echo "→ projets.date_projet supprimée\n";
    }

    // --- projets : ajout de la catégorie ---
    if (!colonneExiste($pdo, 'projets', 'categorie_projet')) {
        $pdo->exec('ALTER TABLE projets ADD COLUMN categorie_projet TEXT');
        echo "→ projets.categorie_projet créée\n";

        // Valeurs déduites des descriptions de projets (À AJUSTER si besoin)
        // 1 MaMusique, 2 Tonnerre 2 Zeus, 3 TheGuardian, 4 AD Personal Training = Site
        // 5 TwoSeeToSee = Jeu
        $pdo->exec("UPDATE projets SET categorie_projet = 'Site' WHERE id_projet IN (1, 2, 3, 4)");
        $pdo->exec("UPDATE projets SET categorie_projet = 'Jeu' WHERE id_projet = 5");
        echo "→ projets.categorie_projet remplie (à vérifier/ajuster)\n";
    } else {
        echo "→ projets.categorie_projet déjà présente, rien à faire\n";
    }

    // --- correction des chemins d'images : tu as renommé les fichiers en 1.png/2.png/...
    // sur le disque, la base pointe encore vers les anciens noms. Idempotent : si les
    // anciens chemins n'existent plus en base (déjà corrigé), les UPDATE ne font rien.
    $correctionsIllustration = [
        1 => 'images/Projets/MaMusique/1.png',
        2 => 'images/Projets/Site Tonnerre 2 Zeus/1.png',
        3 => 'images/Projets/TheGuardian/1.png',
        4 => 'images/Projets/Site ADPT/1.webp',
        5 => 'images/Projets/TwoSeeToSee/1.png',
    ];
    $stmtIllustration = $pdo->prepare('UPDATE projets SET illustration_projet = ? WHERE id_projet = ?');
    foreach ($correctionsIllustration as $idProjet => $nouveauChemin) {
        $stmtIllustration->execute([$nouveauChemin, $idProjet]);
    }
    echo "→ chemins d'illustration_projet resynchronisés avec les fichiers renommés\n";

    // Galerie : on vide et on réinsère avec les nouveaux noms plutôt que de deviner
    // une correspondance ancien nom → nouveau nom ligne par ligne.
    $pdo->exec('DELETE FROM images_projet');
    $galerie = [
        [1, 'images/Projets/MaMusique/2.png'],
        [1, 'images/Projets/MaMusique/3.png'],
        [5, 'images/Projets/TwoSeeToSee/2.png'],
        [5, 'images/Projets/TwoSeeToSee/3.png'],
        [5, 'images/Projets/TwoSeeToSee/5.png'],
        [5, 'images/Projets/TwoSeeToSee/7.png'],
        [5, 'images/Projets/TwoSeeToSee/9.png'],
        [3, 'images/Projets/TheGuardian/2.png'],
    ];
    $stmtGalerie = $pdo->prepare('INSERT INTO images_projet (id_projet, url_image) VALUES (?, ?)');
    foreach ($galerie as [$idProjet, $chemin]) {
        $stmtGalerie->execute([$idProjet, $chemin]);
    }
    echo "→ images_projet reconstruite avec les nouveaux noms de fichiers\n";

    // --- competences.type_competence : remapping vers le nouvel enum TypeCompetence ---
    // L'ancien "Logiciel" n'existe plus, éclaté en Outil/Back/Design selon la compétence.
    // Idempotent par nature : re-forcer la même valeur ne casse rien si déjà appliqué.
    $remappingType = [
        10 => 'Outil',  // Visual Studio Code
        11 => 'Back',   // MySQL
        12 => 'Design', // Figma
        13 => 'Design', // InDesign
        14 => 'Design', // Illustrator
        15 => 'Design', // Photoshop
    ];
    $stmtType = $pdo->prepare('UPDATE competences SET type_competence = ? WHERE id_competence = ?');
    foreach ($remappingType as $idCompetence => $nouveauType) {
        $stmtType->execute([$nouveauType, $idCompetence]);
    }
    echo "→ competences.type_competence remappé vers le nouvel enum (fini avec 'Logiciel')\n";

    $pdo->commit();
    $pdo->exec('PRAGMA foreign_keys = ON;');
    echo "\nMigration terminée ✅\n";
} catch (\Throwable $e) {
    $pdo->rollBack();
    echo "\n❌ Migration annulée : " . $e->getMessage() . "\n";
    exit(1);
}
