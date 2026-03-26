<?php

declare(strict_types=1);

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreditCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cardNumber', TextType::class, [
                'label' => 'Card Number :',
            ])
            ->add('expirationDate', ExpirationDateType::class, [
                'label' => 'Expiration Date :',
            ])
            ->add('cvv', TextType::class, [
                'attr' => [
                    'maxlength' => 3,
                ],
            ])
            ->add('billingAddress', BillingAddressType::class)
            ->add('shippingAddress', ShippingAddressType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'label' => false,
            'enable_csrf' => true,
            'csrf_token_id' => '__pay',
            'csrf_field_name' => '_pay_token',
        ]);
    }
}
