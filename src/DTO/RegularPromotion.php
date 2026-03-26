<?php

declare(strict_types=1);

namespace App\DTO;

class RegularPromotion extends Promotion
{
    public function compute(float $initialPrice): float
    {
        if ($this->value < 0) {
            throw new \InvalidArgumentException('Promotion value cannot be negative.');
        }
        
        if ($this->value > $initialPrice) {
            return 0;
        }
        
        return $initialPrice - $this->value;
    }
}
