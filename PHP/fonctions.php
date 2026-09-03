<?php

use Portfolio\Domain\Model\Competence\Competence;
use Portfolio\Domain\Model\Projet\Projet;

/**
 * Génère une balise <picture> avec des sources d'images conditionnelles.
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

function obtenirAge(): int
{
    $dateNaissance = new DateTime('2005-12-28');
    $dateActuelle = new DateTime();
    return $dateActuelle->diff($dateNaissance)->y;
}

/**
 * Affiche une carte projet complète (empilée) : titre/catégorie/année,
 * bandeau des compétences liées, carrousel lazy-loadé (toutes les images
 * dans le DOM dès le rendu, loading="lazy" fait le travail), liens.
 *
 * @param Competence[] $competencesLiees
 */
function displayProject(Projet $projet, array $competencesLiees): string
{
    $idProjet = $projet->id()->value();
    $images = $projet->toutesLesImages();

    ob_start(); ?>
    <article class="projet-card flex column gap-medium" data-id-projet="<?= $idProjet ?>">

        <header class="projet-entete flex row justify-content-between align-items-center">
            <div class="flex gap-small align-items-center">
                <h3><?= htmlspecialchars($projet->titre()) ?></h3>
                <span class="badge badge-categorie"><?= htmlspecialchars($projet->categorie()->value) ?></span>
            </div>
            <?php if ($projet->annee() !== null): ?>
                <span class="projet-annee"><?= (int) $projet->annee() ?></span>
            <?php endif; ?>
        </header>

        <?php if (!empty($competencesLiees)): ?>
            <ul class="banderole-competences flex row gap-medium flex-wrap">
                <?php foreach ($competencesLiees as $competence): ?>
                    <li class="flex align-items-center gap-small">
                        <?php if ($competence->getImage()): ?>
                            <?= makePicture($competence->getImage(), "Logo de " . $competence->getNom(), 'icon-tiny', paramSup: 'loading="lazy"') ?>
                        <?php endif; ?>
                        <span><?= htmlspecialchars($competence->getNom()) ?></span>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="projet-carrousel" data-carrousel data-index-actif="0">
            <div class="carrousel-slides">
                <?php foreach ($images as $i => $urlImage): ?>
                    <div class="carrousel-slide aspect-16-9<?= $i === 0 ? ' active' : '' ?>" data-slide-index="<?= $i ?>">
                        <img src="<?= htmlspecialchars($urlImage) ?>"
                             alt="Illustration de <?= htmlspecialchars($projet->titre()) ?>"
                             loading="lazy" decoding="async">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php if (count($images) > 1): ?>
                <button type="button" class="arrow left-arrow" data-carrousel-prev aria-label="Image précédente">&#10094;</button>
                <button type="button" class="arrow right-arrow" data-carrousel-next aria-label="Image suivante">&#10095;</button>
            <?php endif; ?>
        </div>

        <p class="projet-description overflowX-scroll"><?= htmlspecialchars($projet->texte()) ?></p>

        <div class="projet-liens flex row justify-content-between">
            <?php if ($projet->urlProjet()): ?>
                <a href="<?= htmlspecialchars($projet->urlProjet()) ?>" target="_blank" rel="noopener">
                    <button class="button">Découvrir le projet</button>
                </a>
            <?php else: ?>
                <span></span>
            <?php endif; ?>
            <?php if ($projet->urlGitHub()): ?>
                <a href="<?= htmlspecialchars($projet->urlGitHub()) ?>" target="_blank" rel="noopener">
                    <button class="button">Voir le code</button>
                </a>
            <?php endif; ?>
        </div>
    </article>
<?php
    return ob_get_clean();
}

/**
 * Affiche les compétences groupées par type (le mot-type au centre,
 * les cartes autour — l'effet "magnétique" viendra en CSS/GSAP plus tard,
 * ici on pose juste le HTML/les data-attributes nécessaires).
 *
 * @param array<string, Competence[]> $groupes
 */
function displayCompetencesGroupees(array $groupes): void
{
    foreach ($groupes as $type => $competences) {
        echo '<div class="groupe-competences" data-type-competence="' . htmlspecialchars($type) . '">';
        echo '<h3 class="type-competence-label">' . htmlspecialchars($type) . '</h3>';
        echo '<div class="cartes-competences flex row flex-wrap gap-medium">';
        foreach ($competences as $competence) {
            echo '<div class="carte-competence flex column align-items-center gap-small" data-id-competence="' . $competence->getId()->getValue() . '">';
            if ($competence->getImage()) {
                echo makePicture($competence->getImage(), "Logo de " . $competence->getNom(), 'icon-small', paramSup: 'loading="lazy"');
            }
            echo '<span>' . htmlspecialchars($competence->getNom()) . '</span>';
            echo '</div>';
        }
        echo '</div></div>';
    }
}
