<?php

namespace App\Form;

use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use App\Entity\Transaction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RemoveMoneyType extends AbstractType
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

            ])
            ->add('quantity', NumberType::class,
                ['label' => false,
                    'html5' => true,
                    'attr' => [
                        'step' => 0.00001,
                        'min' => 0.001,
                        "placeholder" => 0.001,
                        "class" => "form-control"
                    ]
                ])
            ->add('price', HiddenType::class, [
                'data' => 45,
            ]);


    }


    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
