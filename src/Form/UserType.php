<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\User;
use App\Entity\UserPicture;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add('username')
            ->add('firstName')
            ->add('lastName')
            ->add('dateOfBirth')
            ->add('registrationDate')
            ->add('gender',EntityType::class, [
                'required' => false,
                'class' => Gender::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('g')
                        ->orderBy('g.label', 'ASC')
                        ;
                }
            ])
            ->add('userPicture',EntityType::class,[
                'label'=>'userPicture',
                'required' => true,
                'class'=> UserPicture::class,
                'choice_label' => 'name',

            ])
            ->add('address',EntityType::class,[
                'label'=>'address',
                'required' => true,
                'class'=> UserPicture::class,
                'choice_label' => 'name',

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
