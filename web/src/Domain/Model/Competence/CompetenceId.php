<?php

namespace Portfolio\Domain\Model\Competence;

final class CompetenceId
{
    public function __construct(private readonly int $value)
    {
    }

    public function value(): int
    {
        return $this->value;
    }

    public function equals(CompetenceId $other): bool
    {
        return $this->value === $other->value;
    }
}
