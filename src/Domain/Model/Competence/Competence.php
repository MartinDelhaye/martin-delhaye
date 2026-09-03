<?php

namespace Portfolio\Domain\Model\Competence;

final class Competence
{
    public function __construct(
        private readonly CompetenceId $id,
        private readonly string $nom,
        private readonly ?string $image,
        private readonly TypeCompetence $type
    ) {}

    public function getId(): CompetenceId
    {
        return $this->id;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getType(): TypeCompetence
    {
        return $this->type;
    }
}
