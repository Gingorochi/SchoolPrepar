<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminDashboardController extends AbstractController
{
    #[Route('', name: 'dashboard')]
    public function index(): Response
    {
        // Stats à remplacer par des requêtes Doctrine ultérieurement
        $stats = [
            'filieres'       => 4,
            'etablissements' => 4,
            'utilisateurs'   => 0,
        ];

        $dernieresFilieres = [
            ['nom' => 'Génie Logiciel', 'domaine' => 'Informatique', 'duree' => 3],
            ['nom' => 'Réseaux & Télécoms', 'domaine' => 'Informatique', 'duree' => 3],
            ['nom' => 'Intelligence Artificielle', 'domaine' => 'Data Science', 'duree' => 2],
        ];

        $derniersEtablissements = [
            ['nom' => 'IP Net Institute', 'ville' => 'Lomé', 'filieres' => [1, 2]],
            ['nom' => 'Université de Lomé', 'ville' => 'Lomé', 'filieres' => [1, 2, 3]],
            ['nom' => 'ESTIM', 'ville' => 'Lomé', 'filieres' => [1]],
        ];

        return $this->render('admin/dashboard.html.twig', [
            'stats'                 => $stats,
            'dernieresFilieres'     => $dernieresFilieres,
            'derniersEtablissements'=> $derniersEtablissements,
        ]);
    }
}
