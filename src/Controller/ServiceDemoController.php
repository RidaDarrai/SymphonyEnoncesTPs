<?php

declare(strict_types=1);

namespace App\Controller;

use App\Cart\Handler\CartHandler;
use App\Cart\Persist\CartPersister;
use App\Cart\Promotion\PromotionService;
use App\DTO\Cart;
use App\DTO\PercentagePromotion;
use App\DTO\RegularPromotion;
use App\Service\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ServiceDemoController extends AbstractController
{
    public function __construct(
        private CartHandler $cartHandler,
        private CartPersister $cartPersister,
        private PromotionService $promotionService,
        private Mailer $newsletterMailer,
        private Mailer $registerMailer,
        private Mailer $alertMailer,
    ) {
    }

    #[Route('/demo/services', name: 'demo_services')]
    public function index(): Response
    {
        return $this->render('services/index.html.twig', [
            'controller_name' => 'ServiceDemoController',
        ]);
    }

    #[Route('/demo/services/cart/regular', name: 'demo_services_cart_regular')]
    public function cartRegular(): Response
    {
        $cart = new Cart(1500.00);
        $promotion = new RegularPromotion(200.00);
        
        $result = $this->cartHandler->handle($cart, [$promotion]);

        return $this->json([
            'success' => $result,
            'cart' => [
                'raw_price' => $cart->getTotalRawPrice(),
                'net_price' => $cart->getTotalNetPrice(),
                'promotion_type' => 'Regular',
                'promotion_value' => $promotion->getValue(),
            ],
        ]);
    }

    #[Route('/demo/services/cart/percentage', name: 'demo_services_cart_percentage')]
    public function cartPercentage(): Response
    {
        $cart = new Cart(1500.00);
        $promotion = new PercentagePromotion(20.00);
        
        $result = $this->cartHandler->handle($cart, [$promotion]);

        return $this->json([
            'success' => $result,
            'cart' => [
                'raw_price' => $cart->getTotalRawPrice(),
                'net_price' => $cart->getTotalNetPrice(),
                'promotion_type' => 'Percentage',
                'promotion_value' => $promotion->getValue(),
            ],
        ]);
    }

    #[Route('/demo/services/mailer', name: 'demo_services_mailer')]
    public function mailerDemo(): Response
    {
        $info = [
            'newsletter_mailer' => 'newsletter@eheio.ma',
            'register_mailer' => 'register@eheio.ma',
            'alert_mailer' => 'alert@eheio.ma',
        ];

        return $this->json([
            'mailers' => $info,
            'note' => 'Configure MAILER_DSN in .env to send real emails',
        ]);
    }
}
