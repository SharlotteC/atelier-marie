<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastname', TextType::class, [
            'attr' => [
                'placeholder' => 'Nom*'
            ]
        ])
        ->add('firstname' , TextType::class, [
            'attr' => [
                'placeholder' => 'Prénom*'
            ]
        ])
        ->add('Email' , EmailType::class, [
            'attr' => [
                'placeholder' => 'Email*'
            ]
        ])
        ->add('rdvDate', DateType::class, array(

            'widget' => 'single_text',
            'format' => 'yyyy-MM-dd',
        ))
        ->add('hourDate', TimeType::class, array(

            'widget' => 'choice',
            'input' => 'datetime'
        ))
    ;
}

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
