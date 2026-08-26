<?php

use Portfolio\Domain\Model\Competence\Competence;

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

/**
 * @deprecated Conservée pour les usages non encore migrés vers les repositories DDD
 * (à confirmer une fois index.php vu en entier). Ne plus utiliser pour
 * competences/projets, qui passent maintenant par CompetenceRepository/ProjetRepository.
 */
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

/**
 * Affiche récursivement une liste de compétences racines (et leurs enfants).
 * Remplace displayCompetences()/addChild() : plus besoin de deux listes séparées
 * (parents/sous-compétences) ni de gérer la profondeur à la main, l'arbre est
 * déjà construit par Competence::construireArbre().
 *
 * @param Competence[] $racines
 */
function displayCompetences(array $racines): void
{
    foreach ($racines as $competence) {
        displayCompetence($competence, 0);
        echo '</div>';
    }
}

function displayCompetence(Competence $competence, int $level): void
{
    $imageHtml = $competence->image()
        ? makePicture($competence->image(), "Logo de " . $competence->nom(), 'icon-small', paramSup: 'loading="lazy"')
        : '';

    echo '<div class="flex column gap-small competence competence-' . $level . '"'
        . ' data-id-competence="' . $competence->id()->value() . '">'
        . '<div class="flex gap-small">' . $imageHtml . htmlspecialchars($competence->nom()) . '</div>';

    foreach ($competence->enfants() as $enfant) {
        displayCompetence($enfant, $level + 1);
    }

    if ($level > 0) {
        echo '</div>';
    }
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
            'illustration-projet',
            paramSup: 'loading="lazy"',
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