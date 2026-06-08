<?php

namespace App\Form;

use App\Entity\Filiere;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class FiliereType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Nom de la filière',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Informatique, Gestion, Médecine...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le nom de la filière est obligatoire',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('domaine', TextType::class, [
                'label' => 'Domaine d\'étude',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Sciences, Lettres, Arts...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le domaine est obligatoire',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Le domaine doit contenir au moins {{ limit }} caractères',
                        'max' => 100,
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description détaillée',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 4,
                    'placeholder' => 'Décrivez le contenu de la filière, les débouchés...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description est obligatoire',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères',
                        'max' => 2000,
                    ]),
                ],
            ])
            ->add('duree', IntegerType::class, [
                'label' => 'Durée de formation (années)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 3, 4, 5...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La durée est obligatoire',
                    ]),
                    new Positive([
                        'message' => 'La durée doit être un nombre positif',
                    ]),
                ],
            ])
            ->add('langue', ChoiceType::class, [
                'label' => 'Langue d\'enseignement',
                'choices' => [
                    'Français' => 'Français',
                    'Anglais' => 'Anglais',
                    'Espagnol' => 'Espagnol',
                    'Bilingue' => 'Bilingue'
                ],
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La langue d\'enseignement est obligatoire',
                    ]),
                ],
            ])
            ->add('imageFile', \Symfony\Component\Form\Extension\Core\Type\FileType::class, [
                'label' => 'Image représentative',
                'required' => true,
                'attr' => [
                    'class' => 'form-control',
                ],
                'constraints' => [
                    new \Symfony\Component\Validator\Constraints\File([
                        'maxSize' => '5M',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                            'image/webp',
                            'image/gif',
                        ],
                        'mimeTypesMessage' => 'Veuillez uploader une image valide (jpeg/png/webp/gif).',
                    ]),
                ],
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
