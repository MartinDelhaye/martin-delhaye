<?php

namespace Portfolio\Domain\Model\Projet;

/**
 * Value Object : une image n'existe jamais seule, elle appartient
 * toujours à un Projet. Pas d'identité propre exposée au métier.
 */
final class ImageProjet
{
    public function __construct(private readonly string $urlImage)
    {
    }

    public function url(): string
    {
        return $this->urlImage;
    }
}
