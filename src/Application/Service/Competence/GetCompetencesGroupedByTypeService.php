<?php

namespace Portfolio\Application\Service\Competence;

use Portfolio\Domain\Model\Competence\CompetenceRepositoryInterface;
use Portfolio\Domain\Model\Competence\TypeCompetence;

/**
 * Remplace GetCompetencesTreeService (supprimé, plus de hiérarchie).
 * Regroupe la liste plate de compétences par TypeCompetence, dans l'ordre
 * de déclaration de l'enum, prêt pour l'affichage "cartes groupées".
 */
final class GetCompetencesGroupedByTypeService
{
    public function __construct(private readonly CompetenceRepositoryInterface $competenceRepository)
    {
    }

    /** @return array<string, \Portfolio\Domain\Model\Competence\Competence[]> clé = valeur de l'enum */
    public function execute(): array
    {
        $toutes = $this->competenceRepository->findAll();

        $groupes = [];
        foreach (TypeCompetence::cases() as $type) {
            $groupes[$type->value] = [];
        }

        foreach ($toutes as $competence) {
            $groupes[$competence->type()->value][] = $competence;
        }

        // On retire les groupes vides (pas de compétence de ce type actuellement)
        return array_filter($groupes, fn (array $liste) => count($liste) > 0);
    }
}
