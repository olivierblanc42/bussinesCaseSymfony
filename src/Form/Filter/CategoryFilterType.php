<?php

namespace App\Form\Filter;

use App\Entity\Category;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('parent',TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
