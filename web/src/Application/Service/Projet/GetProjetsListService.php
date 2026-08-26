<?php

namespace Portfolio\Application\Service\Projet;

use Portfolio\Domain\Model\Projet\ProjetRepositoryInterface;

final class GetProjetsListService
{
    public function __construct(private readonly ProjetRepositoryInterface $projetRepository)
    {
    }

    /** @return \Portfolio\Domain\Model\Projet\Projet[] */
    public function execute(): array
    {
        return $this->projetRepository->findAll();
    }
}
