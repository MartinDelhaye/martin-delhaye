<?php

namespace Portfolio\Domain\Model\Competence;

/**
 * Étiquette unique par compétence (nature OU domaine, jamais les deux
 * en même temps — décision prise pour rester simple). Ex: MySQL = Back
 * plutôt que MySQL = Back + Logiciel.
 */
enum TypeCompetence: string
{
    case Langage = 'Langage';
    case Framework = 'Framework';
    case Librairie = 'Librairie';
    case CMS = 'CMS';
    case Back = 'Back';
    case Design = 'Design';
    case Outil = 'Outil';
}
