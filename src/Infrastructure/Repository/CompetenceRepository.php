<?php

namespace Portfolio\Infrastructure\Repository;

use PDO;
use Portfolio\Domain\Model\Competence\Competence;
use Portfolio\Domain\Model\Competence\CompetenceId;
use Portfolio\Domain\Model\Competence\CompetenceRepositoryInterface;
use Portfolio\Domain\Model\Competence\TypeCompetence;

final class CompetenceRepository implements CompetenceRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    /** @return Competence[] */
    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id_competence, nom_competence, image_competence, type_competence, description
             FROM competences ORDER BY nom_competence'
        );

        return array_map([$this, 'hydrater'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    public function findById(CompetenceId $id): ?Competence
    {
        $stmt = $this->pdo->prepare(
            'SELECT id_competence, nom_competence, image_competence, type_competence, description
             FROM competences WHERE id_competence = ?'
        );
        $stmt->execute([$id->getValue()]);
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ligne === false ? null : $this->hydrater($ligne);
    }

    /** @return Competence[] */
    public function findByProjetId(int $idProjet): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT c.id_competence, c.nom_competence, c.image_competence, c.type_competence, c.description
             FROM competences c
             INNER JOIN projet_competence pc ON pc.id_competence = c.id_competence
             WHERE pc.id_projet = ?
             ORDER BY c.nom_competence'
        );
        $stmt->execute([$idProjet]);

        return array_map([$this, 'hydrater'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    private function hydrater(array $ligne): Competence
    {
        return new Competence(
            new CompetenceId((int) $ligne['id_competence']),
            $ligne['nom_competence'],
            $ligne['image_competence'],
            TypeCompetence::from($ligne['type_competence']),
            $ligne['description']
        );
    }
}
