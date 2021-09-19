<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddMoneyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('cryptoName', ChoiceType::class, [
                'choices' => [
                    'BTC (Bitcoin)' => 'Bitcoin',
                    'ETH (Ethereum)' => 'Ethereum',
                    'XRP (Ripple)' => 'Ripple'
                ],
                'placeholder' => 'Sélectionner une crypto'
            ])
            ->add('quantity', NumberType::class,
                ['label' => false,
                    'html5' => true,
                    'attr' => [
                        'step' => 0.00001,
                        'min' => 0.001,
                        "placeholder" => "Quantité",
                        "class" => "form-control"
                    ]
                ])
            ->add('price', NumberType::class,
                ['label' => false,
                    'html5' => true,
                    'attr' => [
                        'step' => 0.0001,
                        'min' => 0.001,
                        "placeholder" => "Prix d'achat",
                        "class" => "form-control, color-light"
                    ]
                ]);

    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
