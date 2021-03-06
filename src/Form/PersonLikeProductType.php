<?php

namespace App\Form;

use App\Entity\Person;
use App\Entity\Product;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonLikeProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('person', EntityType::class, array(
                'placeholder' => '- wpisz login -',
                'class' => Person::class,
                'label' => 'Użytkownik',
                'choice_label' => 'login',
                'attr' => [
                    'class' => 'js-data-person-ajax',
                    'style' => 'width: 300px;'
                ]
            ))
            ->add('product', EntityType::class, array(
                'placeholder' => '- wpisz nazwę -',
                'class' => Product::class,
                'label' => 'Product',
                'choice_label' => 'name',
                'attr' => [
                    'class' => 'js-data-product-ajax',
                    'style' => 'width: 300px;'
                ]
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}