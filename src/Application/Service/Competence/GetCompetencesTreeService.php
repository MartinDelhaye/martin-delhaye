<?php

namespace Portfolio\Application\Service\Competence;

use Portfolio\Domain\Model\Competence\Competence;
use Portfolio\Domain\Model\Competence\CompetenceRepositoryInterface;

final class GetCompetencesTreeService
{
    public function __construct(private readonly CompetenceRepositoryInterface $competenceRepository)
    {
    }

    /** @return Competence[] racines, chacune avec ses enfants déjà rattachés */
    public function execute(): array
    {
        $toutes = $this->competenceRepository->findAll();

        return Competence::construireArbre($toutes);
    }
}
