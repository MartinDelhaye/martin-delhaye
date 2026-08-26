<?php

namespace Portfolio\Application\Service\Projet;

use Portfolio\Domain\Model\Projet\Projet;
use Portfolio\Domain\Model\Projet\ProjetId;
use Portfolio\Domain\Model\Projet\ProjetRepositoryInterface;

final class GetProjetByIdService
{
    public function __construct(private readonly ProjetRepositoryInterface $projetRepository)
    {
    }

    public function execute(int $idProjet): ?Projet
    {
        return $this->projetRepository->findById(new ProjetId($idProjet));
    }
}
