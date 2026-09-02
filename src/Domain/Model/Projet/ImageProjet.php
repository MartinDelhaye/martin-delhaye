<?php

namespace Portfolio\Domain\Model\Projet;

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
