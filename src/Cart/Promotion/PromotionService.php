<?php

declare(strict_types=1);

namespace App\Cart\Promotion;

use App\DTO\Cart;
use App\DTO\Promotion;

final class PromotionService
{
    public function apply(Promotion $promotion, Cart $cart): Cart
    {
        return $cart->apply($promotion);
    }
}
