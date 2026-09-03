<?php

namespace Portfolio\Domain\Model\Projet;

final class ProjetId
{
    public function __construct(private readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(ProjetId $other): bool
    {
        return $this->value === $other->value;
    }
}