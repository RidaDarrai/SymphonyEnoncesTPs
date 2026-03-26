<?php

declare(strict_types=1);

namespace App\DTO;

class PercentagePromotion extends Promotion
{
    public function compute(float $initialPrice): float
    {
        if ($this->value < 0 || $this->value > 100) {
            throw new \InvalidArgumentException('Percentage must be between 0 and 100.');
        }
        
        return $initialPrice * (1 - 0.01 * $this->value);
    }
}
