<?php

namespace Portfolio\Domain\Model\Competence;

final class Competence
{
    /** @var Competence[] */
    private array $enfants = [];

    public function __construct(
        private readonly CompetenceId $id,
        private readonly string $nom,
        private readonly ?string $image,
        private readonly string $type,
        private readonly ?CompetenceId $parentId,
        private readonly ?string $description
    ) {
    }

    public function id(): CompetenceId
    {
        return $this->id;
    }

    public function nom(): string
    {
        return $this->nom;
    }

    public function image(): ?string
    {
        return $this->image;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function parentId(): ?CompetenceId
    {
        return $this->parentId;
    }

    public function description(): ?string
    {
        return $this->description;
    }

    public function ajouterEnfant(Competence $enfant): void
    {
        $this->enfants[] = $enfant;
    }

    /** @return Competence[] */
    public function enfants(): array
    {
        return $this->enfants;
    }

    /**
     * Construit une arborescence à partir d'une liste plate de compétences.
     * Remplace la logique de fonctions.php (displayCompetences/addChild),
     * qui gérait la profondeur "à la main" et se limitait à 3 niveaux
     * codés en dur. Ici la profondeur est illimitée et automatique.
     *
     * @param Competence[] $toutes liste plate, un item par ligne de la table
     * @return Competence[] racines (parent_id === null), enfants rattachés récursivement
     */
    public static function construireArbre(array $toutes): array
    {
        $parId = [];
        foreach ($toutes as $competence) {
            $parId[$competence->id()->value()] = $competence;
        }

        $racines = [];
        foreach ($toutes as $competence) {
            $parentId = $competence->parentId();

            if ($parentId === null) {
                $racines[] = $competence;
                continue;
            }

            if (isset($parId[$parentId->value()])) {
                $parId[$parentId->value()]->ajouterEnfant($competence);
            }
        }

        return $racines;
    }
}
