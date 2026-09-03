<?php

namespace Portfolio\Infrastructure\Repository;

use Portfolio\Domain\Model\Projet\CategorieProjet;
use Portfolio\Domain\Model\Projet\ImageProjet;
use Portfolio\Domain\Model\Projet\Projet;
use Portfolio\Domain\Model\Projet\ProjetId;
use Portfolio\Domain\Model\Projet\ProjetRepositoryInterface;

final class FileProjetRepository implements ProjetRepositoryInterface
{
    public function __construct(
        private readonly string $cheminProjets,
        private readonly string $dossierImages = 'images/Projets/'
    ) {
    }

    public function findById(ProjetId $id): ?Projet
    {
        foreach (JsonFileReader::lire($this->cheminProjets) as $ligne) {
            if ($ligne['id'] === $id->value()) {
                return $this->hydrater($ligne);
            }
        }
        return null;
    }

    /** @return Projet[] */
    public function findAll(): array
    {
        $lignes = JsonFileReader::lire($this->cheminProjets);
        $projets = array_map([$this, 'hydrater'], $lignes);

        usort($projets, fn (Projet $a, Projet $b) => ($b->annee() ?? 0) <=> ($a->annee() ?? 0));

        return $projets;
    }

    /** @return Projet[] */
    public function findByCompetenceId(string $idCompetence): array
    {
        $lignes = array_filter(
            JsonFileReader::lire($this->cheminProjets),
            fn (array $ligne) => in_array($idCompetence, $ligne['competences'] ?? [], true)
        );

        return array_map([$this, 'hydrater'], array_values($lignes));
    }

    private function hydrater(array $ligne): Projet
    {
        $images = array_map(
            fn (string $url) => new ImageProjet($this->dossierImages . $url),
            $ligne['images'] ?? []
        );

        return new Projet(
            new ProjetId($ligne['id']),
            $ligne['titre'],
            $ligne['texte'],
            $ligne['annee'] ?? null,
            CategorieProjet::from($ligne['categorie']),
            $ligne['url'] ?? null,
            $ligne['urlGithub'] ?? null,
            $this->dossierImages . $ligne['illustration'],
            $images
        );
    }
}