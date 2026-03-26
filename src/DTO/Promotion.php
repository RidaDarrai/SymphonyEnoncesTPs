<?php

declare(strict_types=1);

namespace App\DTO;

abstract class Promotion
{
    public function __construct(protected float $value)
    {
    }

    abstract public function compute(float $initialPrice): float;

    public function getValue(): float
    {
        return $this->value;
    }
}
