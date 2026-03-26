<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\DTO\RegistrationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class SecurityRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullName', TextType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Le nom complet est requis'),
                    new Assert\Length(min: 2, minMessage: 'Le nom doit contenir au moins {{ limit }} caractères'),
                ],
            ])
            ->add('email', EmailType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'L\'email est requis'),
                    new Assert\Email(message: 'Cette adresse email n\'est pas valide'),
                ],
            ])
            ->add('phone', TelType::class, [
                'constraints' => [
                    new Assert\NotBlank(message: 'Le numéro de téléphone est requis'),
                    new Assert\Regex(
                        pattern: '/^[0-9+\-\s]+$/',
                        message: 'Le numéro de téléphone n\'est pas valide'
                    ),
                ],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Mot de passe',
                    'help' => 'Min 8 caractères, 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spécial (@-_-)',
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ],
                'constraints' => [
                    new Assert\NotBlank(message: 'Le mot de passe est requis'),
                    new Assert\Regex(
                        pattern: '/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@\-_]).{8,}$/',
                        message: 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial'
                    ),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationRequest::class,
        ]);
    }
}
