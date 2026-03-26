<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Attribute\Route;

final class ResponseDemoController extends AbstractController
{
    #[Route('/demo/response', name: 'demo_response')]
    public function index(): Response
    {
        return $this->render('response/index.html.twig', [
            'controller_name' => 'ResponseDemoController',
        ]);
    }

    #[Route('/demo/response/html', name: 'demo_response_html')]
    public function htmlResponse(): Response
    {
        $html = '<!doctype html><html><body><h1>Hello Best Engineers!</h1></body></html>';
        return new Response($html);
    }

    #[Route('/demo/response/json', name: 'demo_response_json')]
    public function jsonResponse(): Response
    {
        $data = [
            'username' => 'issam',
            'phone' => '+0123456789',
        ];
        return new JsonResponse($data);
    }

    #[Route('/demo/response/json/short', name: 'demo_response_json_short')]
    public function jsonResponseShort(): Response
    {
        $cart = [
            'articles' => [
                [
                    'id' => 1,
                    'label' => 'Apple 240W USB-C Charge Cable (2m)',
                    'ordered_item' => [
                        'price' => '29.99',
                        'currency' => 'USD',
                        'quantity' => 1,
                    ],
                ],
                [
                    'id' => 2,
                    'label' => 'SteelSeries APEX Pro TKL Wireless Keyboard',
                    'ordered_item' => [
                        'price' => '161.99',
                        'currency' => 'USD',
                        'quantity' => 1,
                    ],
                ],
            ],
            'order_summary' => [
                'subtotal' => '192.98',
                'currency' => 'USD',
                'estimated_tax' => '13.44',
                'total' => '205.42',
            ],
        ];

        return $this->json($cart);
    }

    #[Route('/demo/response/download/{fileName}', name: 'demo_response_download')]
    public function downloadFile(string $fileName): BinaryFileResponse
    {
        $uploadDir = $this->getParameter('kernel.project_dir') . '/public/uploads';
        $filePath = $uploadDir . '/' . $fileName;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Le fichier que vous cherchez est introuvable.');
        }

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_ATTACHMENT,
            $fileName
        );

        return $response;
    }

    #[Route('/demo/response/stream', name: 'demo_response_stream')]
    public function streamResponse(): Response
    {
        $content = '<!doctype html><html><body><h1>Streamed Response</h1><p>This content is streamed directly.</p></body></html>';
        
        $response = new Response($content);
        $response->headers->set('Content-Type', 'text/html');
        
        return $response;
    }

    #[Route('/demo/response/redirect', name: 'demo_response_redirect')]
    public function redirectResponse(): Response
    {
        return $this->redirectToRoute('demo_response_json');
    }
}
