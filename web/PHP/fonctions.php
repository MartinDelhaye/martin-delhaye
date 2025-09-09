<?php

/**
 * Génère une balise <picture> avec des sources d'images conditionnelles.
 *
 * @param string $img L'URL de l'image par défaut pour les écrans larges.
 * @param string $alt Le texte alternatif de l'image.
 * @param string $class La classe CSS optionnelle de l'image.
 * @param string $id L'ID optionnel de l'image.
 * @param string $paramSup Paramètres supplémentaires à ajouter à l'image (ex: 'loading="lazy"').
 * @param array $sources Un tableau associatif où les clés sont les URLs des images et les valeurs sont les conditions de media (ex: "(max-width: 600px)").
 * @return string Le code HTML généré avec la balise <picture> et ses sources.
 */
function makePicture(string $img, string $alt, string $class = "", string $id = "", string $paramSup = "", array $sources = []): string
{
    $classAttr = $class !== "" ? ' class="' . $class . '"' : '';
    $idAttr = $id !== "" ? ' id="' . $id . '"' : '';
    $html = '<picture>';
    foreach ($sources as $src => $viewportCondition) {
        $html .= '<source media="' . $viewportCondition . '" srcset="' . $src . '">';
    }
    $html .= '<img src="' . $img . '" alt="' . $alt . '" title="' . $alt . '"' . $classAttr . $idAttr . ' ' . $paramSup . ' />';
    $html .= '</picture>';
    return $html;
}

function obtenirDonnees($info, $table, $filtre = '', $trier = '', $type_fetch = 'fetchAll')
{
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
        echo $requete . "<br>";
        die('Erreur : ' . $e->getMessage());
    }
}

function displayCompetences(array $listeCompetencesParents, array $listeSousCompetences): void
{
    foreach ($listeCompetencesParents as $competence) {
        $level = 0;
        displayCompetence($competence, $level);
        addChild($competence["id_competence"], $listeSousCompetences, $level);
        echo '</div>';
    }
};

function addChild(int $id_competence, array $listeSousCompetences, int $level): void
{
    foreach ($listeSousCompetences as $sousCompetences) {
        if ($sousCompetences['parent_id'] == $id_competence) {
            displayCompetence($sousCompetences, $level + 1, $listeSousCompetences);
        }
    }
}

function displayCompetence(array $competence, string $level, ?array $listeSousCompetences = null): void
{
    $imageHtml = makePicture($competence["image_competence"], "Logo de " . $competence['nom_competence'], 'icon-small');
    echo '<div class="flex column gap-small competence competence-' . $level . '">
    <div class="flex gap-small">' . $imageHtml . $competence['nom_competence'] . '</div>';
    if ($level == 1) {
        addChild($competence["id_competence"], $listeSousCompetences, $level + 1);
    }
    if ($level > 0) echo '</div>';
}

function displayProject($testProjet): string
{
    ob_start(); ?>
    <article class="projet flex align-items-center justify-content-center"
        data-id="<?= (int)$testProjet["id_projet"] ?>">
        <p><?= htmlspecialchars($testProjet["titre_projet"]) ?></p>
        <?= makePicture(
            $testProjet["illustration_projet"],
            "illustration de " . $testProjet["titre_projet"],
            'illustration-projet'
        ) ?>
    </article>
<?php
    return ob_get_clean();
}


function obtenirAge(): int
{
    $dateNaissance = new DateTime('2005-12-28');
    $dateActuelle = new DateTime();
    $age = $dateActuelle->diff($dateNaissance)->y;
    return $age;
}