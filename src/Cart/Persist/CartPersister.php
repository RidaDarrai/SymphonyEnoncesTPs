<?php

declare(strict_types=1);

namespace App\Cart\Persist;

use App\DTO\Cart;
use App\DTO\Promotion;

class CartPersister
{
    public function persist(Cart $cart, array $promotions = []): bool
    {
        return true;
    }
}
