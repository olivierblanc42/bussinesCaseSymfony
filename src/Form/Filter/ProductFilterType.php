<?php

namespace App\Form\Filter;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Product;
use App\Entity\Species;
use Doctrine\ORM\EntityRepository;
use Lexik\Bundle\FormFilterBundle\Filter\FilterOperands;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\EntityFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\NumberFilterType;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type\TextFilterType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label', TextFilterType::class, [
                'condition_pattern' => FilterOperands::STRING_CONTAINS, // => 'LIKE %xxxx%'
            ])
            ->add('description')
            ->add('quantityInStock', NumberFilterType::class, [
                'condition_operator' => FilterOperands::OPERATOR_EQUAL,
            ])
            ->add('isActive')
            ->add('priceHt', NumberFilterType::class, [
        'condition_operator' => FilterOperands::OPERATOR_EQUAL,
             ])
            ->add('brand',EntityFilterType::class,[
                'class'=>Brand::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.label', 'ASC')
                        ;
                }

            ])
            ->add('species',EntityFilterType::class,[
                'class'=>Species::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC')
                        ;
                }

            ])
            ->add('category',EntityFilterType::class,[
                'class'=>Category::class,
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
            'data_class' => Product::class,
        ]);
    }
}
