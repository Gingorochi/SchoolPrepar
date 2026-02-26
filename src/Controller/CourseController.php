<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class CourseController extends AbstractController
{
    #[Route('/course', name: 'course_index')]
    public function index(): Response
    {
        $cours = [
            [
                'id' => 1,
                'titre' => 'Fonctions dérivées',
                'matiere' => 'Mathématiques',
                'niveau' => 'Terminale',
                'duree' => '45 minutes',
                'note' => 4.5,
            ],
            [
                'id' => 2,
                'titre' => 'Analyse de texte',
                'matiere' => 'Français',
                'niveau' => 'Seconde',
                'duree' => '30 minutes',
                'note' => 4.0,
            ],
            [
                'id' => 3,
                'titre' => 'Loi de Newton',
                'matiere' => 'Physique',
                'niveau' => 'Première',
                'duree' => '40 minutes',
                'note' => 4.2,
            ],
             [
                'id' => 4,
                'titre' => 'Géologie',
                'matiere' => 'SVT',
                'niveau' => 'Seconde',
                'duree' => '35 minutes',
                'note' => 4.3,
            ],
        ];
        return $this->render('course/index.html.twig', [
        'cours' => $cours,
        ]);
    }
}
