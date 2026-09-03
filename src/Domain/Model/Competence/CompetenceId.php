<?php

namespace Portfolio\Domain\Model\Competence;

final class CompetenceId
{
    public function __construct(private readonly string $value)
    {
    }

    public function value(): string
    {
        return $this->value;
    }

    public function equals(CompetenceId $other): bool
    {
        return $this->value === $other->value;
    }
}