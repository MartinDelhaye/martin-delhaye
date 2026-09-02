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
        private readonly ?int $annee,
        private readonly CategorieProjet $categorie,
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

    public function annee(): ?int
    {
        return $this->annee;
    }

    public function categorie(): CategorieProjet
    {
        return $this->categorie;
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

    /** @return string[] toutes les images (illustration + galerie), pour le carrousel */
    public function toutesLesImages(): array
    {
        $urls = [$this->illustration];
        foreach ($this->images as $image) {
            $urls[] = $image->url();
        }
        return $urls;
    }
}
