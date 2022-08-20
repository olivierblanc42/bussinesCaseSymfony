<?php

namespace App\Form\Filter;

use App\Entity\Address;
use App\Entity\Basket;
use App\Entity\CommandStatus;
use App\Entity\Gender;
use App\Entity\MeansOfPayment;
use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BasketFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('dateCreated')
            ->add('validationDate')
            ->add('invoiceDate')
            ->add('user',EntityFilterType::class,[
        'class'=>User::class,
        'choice_label' => 'username',
        'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('u')
                ->orderBy('u.username', 'ASC')
                ;
        }
    ])
            ->add('address',EntityFilterType::class,[
                'class'=>Address::class,
                'choice_label' => 'city',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('a')
                        ->orderBy('a.city', 'ASC')
                        ;
                }
            ])
            ->add('meansOfPayment',EntityFilterType::class,[
                'class'=>MeansOfPayment::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('m')
                        ->orderBy('m.label', 'ASC')
                        ;
                }
            ])
            ->add('commandStatus',EntityFilterType::class,[
                'class'=>CommandStatus::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.label', 'ASC')
                        ;
                }
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Basket::class,
        ]);
    }
}
