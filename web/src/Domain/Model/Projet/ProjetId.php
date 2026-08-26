<?php

namespace Portfolio\Domain\Model\Projet;

final class ProjetId
{
    public function __construct(private readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(ProjetId $other): bool
    {
        return $this->value === $other->value;
    }
}
