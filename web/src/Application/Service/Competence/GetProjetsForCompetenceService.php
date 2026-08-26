<?php

namespace Portfolio\Application\Service\Competence;

use Portfolio\Domain\Model\Projet\ProjetRepositoryInterface;

final class GetProjetsForCompetenceService
{
    public function __construct(private readonly ProjetRepositoryInterface $projetRepository)
    {
    }

    /** @return \Portfolio\Domain\Model\Projet\Projet[] */
    public function execute(int $idCompetence): array
    {
        return $this->projetRepository->findByCompetenceId($idCompetence);
    }
}
