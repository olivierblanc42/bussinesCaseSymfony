<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\Category;
use App\Entity\Picture;
use App\Entity\Product;
use App\Entity\Species;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('label',TextType::class,[
                'label' => 'Nom',
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('description')
            ->add('quantityInStock', NumberType::class, [
                'label' => 'Quantité en stock',
                'attr' => [
                    'placeholder' => 'Quantité en stock',
                    'min' => 0
                ],
            ])
            ->add('isActive')
            ->add('priceHt', NumberType::class, [
                'label' => 'Prix',
                'attr' => [
                    'placeholder' => 'Prix',
                    'min' => 0
                ],
            ])
            ->add('brand', EntityType::class, [
                'required' => false,
                'class' => Brand::class,
                'choice_label' => 'label',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('b')
                        ->orderBy('b.label', 'ASC')
                        ;
                }
            ])
            ->add('species',EntityType::class,[
                    'label'=>'Espèce',
                    'required' => true,
                    'class'=> Species::class,
                    'choice_label' => 'name',

            ])
            ->add('category',EntityType::class,[
                'label'=>'Categories',
                'required' => true,
                'class'=> Category::class,
                'choice_label' => 'label',

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
