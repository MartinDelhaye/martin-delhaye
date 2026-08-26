<?php

namespace Portfolio\Domain\Model\Projet;

final class Projet
{
    /** @var ImageProjet[] */
    private array $images;

    public function __construct(
        private readonly ProjetId $id,
        private readonly string $titre,
        private readonly string $texte,
        private readonly ?string $date,
        private readonly ?string $urlProjet,
        private readonly ?string $urlGitHub,
        private readonly string $illustration,
        array $images = []
    ) {
        $this->images = $images;
    }

    public function id(): ProjetId
    {
        return $this->id;
    }

    public function titre(): string
    {
        return $this->titre;
    }

    public function texte(): string
    {
        return $this->texte;
    }

    public function date(): ?string
    {
        return $this->date;
    }

    public function urlProjet(): ?string
    {
        return $this->urlProjet;
    }

    public function urlGitHub(): ?string
    {
        return $this->urlGitHub;
    }

    public function illustration(): string
    {
        return $this->illustration;
    }

    /** @return ImageProjet[] */
    public function images(): array
    {
        return $this->images;
    }
}
