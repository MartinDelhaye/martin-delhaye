<?php

namespace Portfolio\Infrastructure\Repository;

use PDO;
use Portfolio\Domain\Model\Projet\CategorieProjet;
use Portfolio\Domain\Model\Projet\ImageProjet;
use Portfolio\Domain\Model\Projet\Projet;
use Portfolio\Domain\Model\Projet\ProjetId;
use Portfolio\Domain\Model\Projet\ProjetRepositoryInterface;

final class ProjetRepository implements ProjetRepositoryInterface
{
    public function __construct(private readonly PDO $pdo)
    {
    }

    public function findById(ProjetId $id): ?Projet
    {
        $stmt = $this->pdo->prepare(
            'SELECT id_projet, titre_projet, texte_projet, annee_projet, categorie_projet, url_projet, urlGitHub_projet, illustration_projet
             FROM projets WHERE id_projet = ?'
        );
        $stmt->execute([$id->value()]);
        $ligne = $stmt->fetch(PDO::FETCH_ASSOC);

        return $ligne === false ? null : $this->hydrater($ligne);
    }

    /** @return Projet[] */
    public function findAll(): array
    {
        $stmt = $this->pdo->query(
            'SELECT id_projet, titre_projet, texte_projet, annee_projet, categorie_projet, url_projet, urlGitHub_projet, illustration_projet
             FROM projets ORDER BY annee_projet DESC, id_projet DESC'
        );

        return array_map([$this, 'hydrater'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    /** @return Projet[] */
    public function findByCompetenceId(int $idCompetence): array
    {
        $stmt = $this->pdo->prepare(
            'SELECT p.id_projet, p.titre_projet, p.texte_projet, p.annee_projet, p.categorie_projet, p.url_projet, p.urlGitHub_projet, p.illustration_projet
             FROM projets p
             INNER JOIN projet_competence pc ON pc.id_projet = p.id_projet
             WHERE pc.id_competence = ?
             ORDER BY p.annee_projet DESC'
        );
        $stmt->execute([$idCompetence]);

        return array_map([$this, 'hydrater'], $stmt->fetchAll(PDO::FETCH_ASSOC));
    }

    private function hydrater(array $ligne): Projet
    {
        $imagesStmt = $this->pdo->prepare('SELECT url_image FROM images_projet WHERE id_projet = ?');
        $imagesStmt->execute([$ligne['id_projet']]);

        $images = array_map(
            fn (array $img) => new ImageProjet($img['url_image']),
            $imagesStmt->fetchAll(PDO::FETCH_ASSOC)
        );

        return new Projet(
            new ProjetId((int) $ligne['id_projet']),
            $ligne['titre_projet'],
            $ligne['texte_projet'],
            $ligne['annee_projet'] !== null ? (int) $ligne['annee_projet'] : null,
            CategorieProjet::from($ligne['categorie_projet']),
            $ligne['url_projet'],
            $ligne['urlGitHub_projet'],
            $ligne['illustration_projet'],
            $images
        );
    }
}
