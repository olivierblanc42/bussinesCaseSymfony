<?php

namespace App\Form;

use App\Entity\Address;
use App\Entity\Basket;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasketType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateCreated')
            ->add('validationDate')
            ->add('invoiceDate')
            ->add('user',EntityType::class,[
                'label'=>'Client',
                'required' => true,
                'class'=>User::class,
                'choice_label' => 'userName',
                ])
            ->add('address',EntityType::class,[
                'label'=>'Address',
                'required' => true,
                'class'=>Address::class,
                'choice_label' => 'city',
            ])
            ->add('meansOfPayment')
            ->add('commandStatus')


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Basket::class,
        ]);
    }
}
