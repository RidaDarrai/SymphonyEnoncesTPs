<?php

namespace App\Controller;

use App\Form\CartType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(CartType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $this->addFlash('success', sprintf(
                'Added %d item(s) to cart (Color: %s)',
                $data['quantity'],
                $data['color']
            ));
        }

        return $this->render('product/index.html.twig', [
            'form' => $form,
        ]);
    }
}
