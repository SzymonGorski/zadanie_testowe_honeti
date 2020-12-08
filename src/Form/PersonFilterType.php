<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('search', TextType::class, array(
                'label' => 'Szukana fraza',
                'required' => false,
            ))
            ->add('state', ChoiceType::class, array(
                'choices' => [
                    'Aktywny' => Person::STATE_ACTIVE,
                    'Zbanowany' => Person::STATE_BANNED,
                    'Usunięty' => Person::STATE_DELETED,
                ],
                'label' => 'Status',
                'required' => false,
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}