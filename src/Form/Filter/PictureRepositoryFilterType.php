<?php

namespace App\Form\Filter;

use App\Entity\Gender;
use App\Entity\Picture;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PictureRepositoryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('path',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('product',EntityFilterType::class,[
                'class'=>Product::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('p')
                        ->orderBy('p.label', 'ASC')
                        ;
                }

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Picture::class,
        ]);
    }
}
