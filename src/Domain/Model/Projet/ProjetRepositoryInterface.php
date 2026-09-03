<?php

namespace Portfolio\Domain\Model\Projet;

interface ProjetRepositoryInterface
{
    public function findById(ProjetId $id): ?Projet;

    /** @return Projet[] */
    public function findAll(): array;

    /** @return Projet[] projets utilisant une compétence donnée */
    public function findByCompetenceId(string $idCompetence): array;
}