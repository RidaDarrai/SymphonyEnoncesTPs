<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\Newsletter;
use App\Service\Mailer\Mailer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

final class NewsletterController extends AbstractController
{
    public function __construct(
        private Mailer $newsletterMailer,
    ) {
    }

    #[Route('/newsletter', name: 'app_newsletter')]
    public function index(): Response
    {
        return $this->render('newsletter/index.html.twig');
    }

    #[Route(path: '/register', name: 'app.newsletter.register', methods: ['POST'])]
    public function registerNewsletter(
        #[MapRequestPayload] Newsletter $newsletter,
    ): Response {
        $this->newsletterMailer->send(
            to: $newsletter->email,
            subject: 'New subscriber to the newsletter',
            body: '<h1>Welcome!</h1><p>A new subscriber has been added: ' . $newsletter->email . '</p>',
        );

        $this->addFlash('success', 'Successfully subscribed with: ' . $newsletter->email);

        return $this->redirectToRoute('app_newsletter');
    }
}
