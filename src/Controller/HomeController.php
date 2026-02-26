<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(): Response
    {
        $matieres = [
            ['nom' => 'Mathématiques', 'cours' => 45],
            ['nom' => 'Français', 'cours' => 38],
            ['nom' => 'Physique', 'cours' => 29],
            ['nom' => 'SVT','cours' => 31],
            ['nom' => 'Histoire','cours' => 22],
            ['nom' => 'Anglais', 'cours' => 27],
        ];

        $stats = [
            'eleves'  => 12450,
            'cours'   => 320,
            'matieres'=> 18,
            'reussite'=> 94,
        ];
        return $this->render('home/index.html.twig', [
            'matieres' => $matieres,
            'stats'    => $stats,
        ]);
    }
}
