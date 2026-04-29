<?php

namespace App\Controller\Admin;

use App\Repository\FiliereRepository;
use App\Repository\EtablissementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin', name: 'admin_')]
class AdminDashboardController extends AbstractController
{
    #[Route('', name: 'dashboard')]
    public function index(FiliereRepository $filiereRepository, EtablissementRepository $etablissementRepository, UserRepository $userRepository): Response
    {
        // Stats réelles de la base de données
        $stats = [
            'filieres'       => $filiereRepository->count([]),
            'etablissements' => $etablissementRepository->count([]),
            'utilisateurs'   => $userRepository->count([]),
        ];

        // Dernières filières (limitées à 3)
        $dernieresFilieres = $filiereRepository->findBy([], ['id' => 'DESC'], 3);

        // Derniers établissements (limités à 3)
        $derniersEtablissements = $etablissementRepository->findBy([], ['id' => 'DESC'], 3);

        return $this->render('admin/dashboard.html.twig', [
            'stats'                 => $stats,
            'dernieresFilieres'     => $dernieresFilieres,
            'derniersEtablissements'=> $derniersEtablissements,
        ]);
    }
}
