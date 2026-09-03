<?php

namespace Portfolio\Infrastructure\Repository;

use Portfolio\Domain\Model\Competence\Competence;
use Portfolio\Domain\Model\Competence\CompetenceId;
use Portfolio\Domain\Model\Competence\CompetenceRepositoryInterface;
use Portfolio\Domain\Model\Competence\TypeCompetence;

final class FileCompetenceRepository implements CompetenceRepositoryInterface
{
    public function __construct(
        private readonly string $cheminCompetences,
        private readonly string $cheminProjets,
        private readonly string $dossierImages = 'images/competences/'
    ) {
    }

    /** @return Competence[] */
    public function findAll(): array
    {
        $lignes = JsonFileReader::lire($this->cheminCompetences);
        return array_map([$this, 'hydrater'], $lignes);
    }

    public function findById(CompetenceId $id): ?Competence
    {
        foreach (JsonFileReader::lire($this->cheminCompetences) as $ligne) {
            if ($ligne['id'] === $id->value()) {
                return $this->hydrater($ligne);
            }
        }
        return null;
    }

    /** @return Competence[] */
    public function findByProjetId(string $idProjet): array
    {
        $projets = JsonFileReader::lire($this->cheminProjets);
        $idsCompetences = [];

        foreach ($projets as $projet) {
            if ($projet['id'] === $idProjet) {
                $idsCompetences = $projet['competences'] ?? [];
                break;
            }
        }

        if (empty($idsCompetences)) {
            return [];
        }

        $toutes = $this->findAll();
        return array_values(array_filter(
            $toutes,
            fn (Competence $c) => in_array($c->getId()->value(), $idsCompetences, true)
        ));
    }

    private function hydrater(array $ligne): Competence
    {
        return new Competence(
            new CompetenceId($ligne['id']),
            $ligne['nom'],
            isset($ligne['image']) ? $this->dossierImages . $ligne['image'] : null,
            TypeCompetence::from($ligne['type'])
        );
    }
}