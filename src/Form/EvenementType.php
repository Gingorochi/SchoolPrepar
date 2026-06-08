<?php

namespace App\Form;

use App\Entity\Evenement;
use App\Entity\Filiere;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class EvenementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre de l\'événement',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Journée portes ouvertes, Conférence...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le titre est obligatoire',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description détaillée',
                'attr' => [
                    'class' => 'form-control',
                    'rows' => 5,
                    'placeholder' => 'Décrivez l\'événement, son programme, les intervenants...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La description est obligatoire',
                    ]),
                    new Length([
                        'min' => 10,
                        'minMessage' => 'La description doit contenir au moins {{ limit }} caractères',
                        'max' => 5000,
                    ]),
                ],
            ])
            ->add('dateDebut', DateTimeType::class, [
                'label' => 'Date de début',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'YYYY-MM-DD HH:MM'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de début est obligatoire',
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de début doit être dans le futur',
                    ]),
                ],
            ])
            ->add('dateFin', DateTimeType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'YYYY-MM-DD HH:MM'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de fin est obligatoire',
                    ]),
                ],
            ])
            ->add('lieu', TextType::class, [
                'label' => 'Lieu de l\'événement',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: Amphithéâtre A, Salle de conférence...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le lieu est obligatoire',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le lieu doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type d\'événement',
                'choices' => [
                    'Conférence' => 'Conférence',
                    'Séminaire' => 'Séminaire',
                    'Atelier' => 'Atelier',
                    'Journée portes ouvertes' => 'Journée portes ouvertes',
                    'Rencontre' => 'Rencontre',
                    'Autre' => 'Autre'
                ],
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Le type d\'événement est obligatoire',
                    ]),
                ],
            ])
            ->add('capacite', IntegerType::class, [
                'label' => 'Capacité (nombre de participants)',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ex: 50, 100, 200...'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La capacité est obligatoire',
                    ]),
                    new Positive([
                        'message' => 'La capacité doit être un nombre positif',
                    ]),
                ],
            ])
            ->add('filiere', EntityType::class, [
                'label' => 'Filière concernée',
                'class' => Filiere::class,
                'choice_label' => 'nom',
                'placeholder' => 'Sélectionnez la filière',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'La filière est obligatoire',
                    ]),
                ],
            ])
            ->add('organisateur', EntityType::class, [
                'label' => 'Organisateur',
                'class' => User::class,
                'choice_label' => function(User $user) {
                    return $user->getPrenom() . ' ' . $user->getNom();
                },
                'placeholder' => 'Sélectionnez l\'organisateur',
                'attr' => ['class' => 'form-control'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'L\'organisateur est obligatoire',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evenement::class,
        ]);
    }
}
