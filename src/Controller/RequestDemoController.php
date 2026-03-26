<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Credentials;
use App\DTO\Pagination;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class RequestDemoController extends AbstractController
{
    #[Route('/demo/request', name: 'demo_request')]
    public function index(Request $request): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'RequestDemoController',
        ]);
    }

    #[Route('/demo/request/query', name: 'demo_request_query')]
    public function queryDemo(Request $request): Response
    {
        $queryParams = $request->query->all();
        $page = $request->query->get('page', 1);
        $pageInt = $request->query->getInt('page', 1);
        $clientIp = $request->server->get('REMOTE_ADDR');
        $userAgent = $request->headers->get('User-Agent');

        return $this->render('default/index.html.twig', [
            'controller_name' => 'RequestDemoController - Query Demo',
            'query_params' => $queryParams,
            'page' => $page,
            'page_int' => $pageInt,
            'client_ip' => $clientIp,
            'user_agent' => $userAgent,
        ]);
    }

    #[Route('/demo/request/post', name: 'demo_request_post', methods: ['GET', 'POST'])]
    public function postDemo(Request $request): Response
    {
        $postData = $request->request->all();
        $payload = $request->getPayload()->all();
        $content = $request->getContent();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'RequestDemoController - POST Demo',
            'post_data' => $postData,
            'payload' => $payload,
            'content' => $content,
        ]);
    }

    #[Route('/demo/request/map-query', name: 'demo_request_map_query')]
    public function mapQueryDemo(#[MapQueryString] Pagination $pagination): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'RequestDemoController - MapQueryString Demo',
            'pagination' => $pagination,
        ]);
    }

    #[Route('/demo/request/api', name: 'demo_request_api', methods: ['POST'])]
    public function apiDemo(#[MapRequestPayload] Credentials $credentials): Response
    {
        return $this->render('default/index.html.twig', [
            'controller_name' => 'RequestDemoController - MapRequestPayload Demo',
            'credentials' => $credentials,
        ]);
    }
}
