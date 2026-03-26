<?php

declare(strict_types=1);

namespace App\Controller;

use App\DTO\RegistrationRequest;
use App\Form\Type\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function index(Request $request): Response
    {
        $registrationDTO = new RegistrationRequest();

        $registerForm = $this->createForm(RegisterType::class, $registrationDTO);
        $registerForm->handleRequest($request);

        if ($registerForm->isSubmitted() && $registerForm->isValid()) {
            $this->addFlash('success', 'Registration successful!');
            return $this->redirectToRoute('app_register');
        }

        return $this->render('register/index.html.twig', [
            'registerForm' => $registerForm,
        ]);
    }
}
