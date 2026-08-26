<?php

namespace Portfolio\Application\Service\Projet;

use Portfolio\Domain\Model\Competence\CompetenceRepositoryInterface;

final class GetCompetencesForProjetService
{
    public function __construct(private readonly CompetenceRepositoryInterface $competenceRepository)
    {
    }

    /** @return \Portfolio\Domain\Model\Competence\Competence[] */
    public function execute(int $idProjet): array
    {
        return $this->competenceRepository->findByProjetId($idProjet);
    }
}
