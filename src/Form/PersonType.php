<?php

namespace App\Form;

use App\Entity\Person;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PersonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('login', TextType::class, array(
                'label' => 'Login'
            ))
            ->add('lastname', TextType::class, array(
                'label' => 'Nazwisko'
            ))
            ->add('firstname', TextType::class, array(
                'label' => 'Imię'
            ))
            ->add('state', ChoiceType::class, array(
                'choices' => [
                    'Aktywny' => Person::STATE_ACTIVE,
                    'Zbanowany' => Person::STATE_BANNED,
                    'Usunięty' => Person::STATE_DELETED,
                ],
                'label' => 'Status'
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([]);
    }
}