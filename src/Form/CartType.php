<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

class CartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'min' => 1,
                    'max' => 10,
                    'value' => 1,
                    'style' => 'max-width: 100px;',
                ],
            ])
            ->add('color', ChoiceType::class, [
                'label' => false,
                'choices' => [
                    'Matte Black' => 'black',
                    'Pearl White' => 'white',
                    'Silver' => 'silver',
                ],
                'attr' => [
                    'class' => 'form-select',
                    'style' => 'max-width: 200px;',
                ],
            ])
            ->add('add_to_cart', SubmitType::class, [
                'label' => 'Add to Cart',
                'attr' => [
                    'class' => 'btn btn-primary btn-lg',
                ],
            ]);
    }
}
