<?php

declare(strict_types=1);

namespace App\Controller;

use App\Form\Type\CreditCardType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PaymentController extends AbstractController
{
    #[Route('/pay', name: 'app_payment')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CreditCardType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success', 'Payment processed successfully!');
            return $this->redirectToRoute('app_payment');
        }

        return $this->render('payment/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
