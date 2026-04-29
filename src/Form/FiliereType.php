<?php

namespace App\Form;

use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la filière',
                'attr' => ['class' => 'form-control']
            ])
            ->add('domaine', TextType::class, [
                'label' => 'Domaine',
                'attr' => ['class' => 'form-control']
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['class' => 'form-control', 'rows' => 4]
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée (années)',
                'attr' => ['class' => 'form-control']
            ])
            ->add('langue', ChoiceType::class, [
                'label' => 'Langue',
                'choices' => [
                    'Français' => 'Français',
                    'Anglais' => 'Anglais',
                    'Espagnol' => 'Espagnol'
                ],
                'attr' => ['class' => 'form-control']
            ])
            ->add('image', TextType::class, [
                'label' => 'Image (nom du fichier)',
                'required' => false,
                'attr' => ['class' => 'form-control']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filiere::class,
        ]);
    }
}
