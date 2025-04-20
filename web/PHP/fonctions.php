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