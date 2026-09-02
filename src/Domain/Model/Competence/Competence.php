<?php

namespace Portfolio\Domain\Model\Competence;

/**
 * Plus de hiérarchie parent/enfant : chaque compétence est autonome,
 * classée par un seul TypeCompetence.
 */
final class Competence
{
    public function __construct(
        private readonly CompetenceId $id,
        private readonly string $nom,
        private readonly ?string $image,
        private readonly TypeCompetence $type,
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

    public function type(): TypeCompetence
    {
        return $this->type;
    }

    public function description(): ?string
    {
        return $this->description;
    }
}
