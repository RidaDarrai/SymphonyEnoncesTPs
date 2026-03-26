<?php

declare(strict_types=1);

namespace App\Cart\Handler;

use App\Cart\Persist\CartPersister;
use App\Cart\Promotion\PromotionService;
use App\DTO\Cart;
use App\DTO\Promotion;

final class CartHandler
{
    public function __construct(
        private CartPersister $cartPersister,
        private PromotionService $promotionService,
    ) {
    }

    public function handle(Cart $cart, array $promotions = []): bool
    {
        if (!\array_all($promotions, fn ($item) => $item instanceof Promotion)) {
            return false;
        }

        foreach ($promotions as $promotion) {
            $this->promotionService->apply($promotion, $cart);
        }

        if ($cart->getTotalRawPrice() <= 0 || $cart->getTotalNetPrice() <= 0) {
            return false;
        }

        return $this->cartPersister->persist($cart, $promotions);
    }
}
