<?php

declare(strict_types=1);

namespace App\Form\Type;

use App\DTO\RegistrationRequest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class)
            ->add('fullName', TextType::class)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'help_html' => true,
                    'help' => '<ul class="mb-0">
                        <li>Doit contenir au minimum 8 caractère</li>
                        <li>Doit inclure au moins une majuscule</li>
                        <li>Doit inclure au moins une minuscule</li>
                        <li>Doit inclure au moins un chiffre</li>
                        <li>Doit inclure au moins un caractère spécial parmi : `@`, `-`, `_`</li>
                    </ul>',
                ],
                'second_options' => [
                    'label' => 'Confirm Password: ',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RegistrationRequest::class,
            'attr' => [
                'novalidate' => 'novalidate',
            ],
        ]);
    }
}
