<?php

namespace Portfolio\Domain\Model\Competence;

interface CompetenceRepositoryInterface
{
    /** @return Competence[] liste plate, non hiérarchisée */
    public function findAll(): array;

    public function findById(CompetenceId $id): ?Competence;

    /** @return Competence[] compétences utilisées par un projet donné */
    public function findByProjetId(int $idProjet): array;
}
