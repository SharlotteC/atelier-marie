<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DevisType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom*'
                ]
            ])
            ->add('firstname', TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom*'
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email*'
                ]
            ])
            ->add('title', ChoiceType::class, [
                'label' => 'prestations souhaitées',
                'placeholder' => 'Selectionez*',
                'choices' => [
                    'Retouche ourlet'=>'Retouche ourlet',
                    'Retouche linge de maison' => 'Retouche linge de maison',
                    'Couture sur mesure' => 'Couture sur mesure',
                    'Rideaux / voilages' => 'Rideaux / voilages',
                    'Retouche cuir / fourrure' => 'Retouche cuir / fourrure',
                    'Restauration vêtement' => 'Restauration vêtement',
                    'Restauration cuir ou fourrure' => 'Restauration cuir ou fourrure',
                    'Autre choix' => 'Autre choix'
                ]

                
            ])
            ->add('content', TextareaType::class, [
                'attr' => [
                    'placeholder' => 'Description*'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
        ]);
    }
}
