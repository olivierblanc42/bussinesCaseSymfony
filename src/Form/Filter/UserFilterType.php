<?php

namespace App\Form\Filter;

use App\Entity\Address;
use App\Entity\Brand;
use App\Entity\Gender;
use App\Entity\User;
use App\Entity\UserPicture;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\DateRangeFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email',TextFilterType::class, [
        'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
    ])
            ->add('username',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('roles')
            ->add('password')
            ->add('firstName',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('lastName',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('dateOfBirth', DateRangeFilterType::class, [
                'left_date_options' => [
                    'label' => 'De',
                    'widget' => 'single_text',
                ],
                'right_date_options' => [
                    'label' => 'à',
                    'widget' => 'single_text',
                ]
            ])
            ->add('registrationDate', DateRangeFilterType::class, [
                'left_date_options' => [
                    'label' => 'De',
                    'widget' => 'single_text',
                ],
                'right_date_options' => [
                    'label' => 'à',
                    'widget' => 'single_text',
                ]
            ])
            ->add('gender',EntityFilterType::class,[
                'class'=>Gender::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.label', 'ASC')
                        ;
                }

            ])
            ->add('userPicture',EntityFilterType::class,[
                'class'=>UserPicture::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
