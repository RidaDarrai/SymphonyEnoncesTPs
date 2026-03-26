<?php

declare(strict_types=1);

namespace App\Controller;

use App\Account\Handler\AccountHandler;
use App\DTO\RegistrationRequest;
use App\Form\Type\SecurityRegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class SecurityController extends AbstractController
{
    public function __construct(
        private AccountHandler $accountHandler
    ) {
    }

    #[Route('/security/register', name: 'app_security_register')]
    public function register(Request $request): Response
    {
        $registrationRequest = new RegistrationRequest();
        $form = $this->createForm(SecurityRegisterType::class, $registrationRequest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $success = $this->accountHandler->register($registrationRequest);
            
            if ($success) {
                $this->addFlash('success', 'Compte créé avec succès! Vous pouvez maintenant vous connecter.');
                return $this->redirectToRoute('app_security_register');
            } else {
                $this->addFlash('error', 'Une erreur est survenue lors de la création du compte.');
            }
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/security/login', name: 'app_security_login')]
    public function login(): Response
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/security/users', name: 'app_security_users')]
    #[IsGranted('ROLE_ADMIN')]
    public function users(): Response
    {
        return $this->render('security/users.html.twig');
    }
}
