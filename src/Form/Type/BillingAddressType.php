<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstName', TextType::class)
            ->add('lastName', TextType::class)
            ->add('country', CountryType::class)
            ->add('addressLine1', TextType::class, [
                'required' => false,
                'help' => 'If your billing address is a PO Box, please enter the number first. Example: PO Box 123 would be entered as 123 PO Box.',
            ])
            ->add('addressLine2', TextType::class, [
                'required' => false,
                'label' => false,
            ])
            ->add('city', TextType::class)
            ->add('state', TextType::class)
            ->add('zipCode', TextType::class)
            ->add('phoneNumber', TextType::class)
            ->add('emailAddress', EmailType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
    }
}
