<?php

namespace Portfolio\Domain\Model\Projet;

enum CategorieProjet: string
{
    case Site = 'Site';
    case Jeu = 'Jeu';
    case AppliMobile = 'Appli mobile';
}
