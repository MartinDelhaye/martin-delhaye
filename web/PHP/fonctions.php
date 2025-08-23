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
function makePicture(string $img, string $alt, string $class = "", string $id = "", string $paramSup = "", array $sources=[]): string
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


// function afficherCompetence($nomCompetence, $imageCompetence){
//     $imageCompetence ? $image = makePicture($imageCompetence, "Logo de ".$nomCompetence, 'icon-small') : $image = '';
//     return '<article class="border-rond background-black flex row align-items-center gap-small padding-small border-radius"> ' . $image . '<p>' . $nomCompetence . '</p></article>';
// }

function afficherCompetence($nom, $image, $isChild = false) {
    $class = $isChild ? 'child-competence' : 'competence';
    $imageHtml = makePicture($image, "Logo de $nom", 'icon-small');
    return "<article class=\"$class border-rond background-black flex row align-items-center gap-small padding-small border-radius\">$imageHtml<p>$nom</p></article>";
}

function afficherCompetenceEtEnfants($competence, $allCompetences, $isChild = false) {
    // Parent
    $html = '<div class="' . ($isChild ? 'child-competence' : 'competence-bloc') . '">';

    if (!$isChild) {
        $html .= '<div class="competence-header">';
        if (!empty($competence['image_competence'])) {
            $html .= makePicture($competence['image_competence'], "Logo de {$competence['nom_competence']}", 'icon-small');
        }
        $html .= '<p class="competence-nom">' . htmlspecialchars($competence['nom_competence']) . '</p>';
        $html .= '</div>';

        if (!empty($competence['description'])) {
            $html .= '<p class="competence-description">' . htmlspecialchars($competence['description']) . '</p>';
        }

        // Enfants
        $id = $competence['id_competence'];
        $enfants = array_filter($allCompetences, fn($c) => $c['parent_id'] == $id);

        if (!empty($enfants)) {
            $html .= '<div class="sous-competences">';
            foreach ($enfants as $enfant) {
                $html .= afficherCompetenceEtEnfants($enfant, $allCompetences, true);
            }
            $html .= '</div>';
        }
    } else {
        // Enfant (et potentiellement parent lui-même)
        $html .= afficherCompetence($competence['nom_competence'], $competence['image_competence'], true);

        // Recherche des sous-enfants
        $id = $competence['id_competence'];
        $enfants = array_filter($allCompetences, fn($c) => $c['parent_id'] == $id);

        if (!empty($enfants)) {
            $html .= '<div class="sous-competences">';
            foreach ($enfants as $enfant) {
                $html .= afficherCompetenceEtEnfants($enfant, $allCompetences, true);
            }
            $html .= '</div>';
        }

    }

    $html .= '</div>';
    return $html;
}




function afficherProjet($id, $titre, $illustration, $date){
    $illustration ? $image = makePicture($illustration, "Illustration de ".$titre, 'width-100') : $image = '';
    return '<a href="projet.php?id_projet=' . $id . '" class="width-33 width-70-mobile"><article class="projets button flex column align-items-center gap-small padding-small"> ' . 
                $image . '
                <h3>' . $titre . '</h3>
                <p class="date">' . $date . '</p>
            </article></a>';
}
