<?php

namespace App\Controller\Admin;

use App\Repository\FiliereRepository;
use App\Repository\EtablissementRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin', name: 'admin_')]
class AdminDashboardController extends AbstractController
{
    #[Route('/', name: 'dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(FiliereRepository $filiereRepository, EtablissementRepository $etablissementRepository, UserRepository $userRepository): Response
    {
        // Stats réelles de la base de données
        $utilisateurs_count = $userRepository->count([]);
        $filieres_count = $filiereRepository->count([]);
        $etablissements_count = $etablissementRepository->count([]);
        $evenements_count = 0;

        // Derniers utilisateurs
        $users = $userRepository->findBy([], ['id' => 'DESC'], 10);

        return $this->render('admin/dashboard.html.twig', [
            'utilisateurs_count'     => $utilisateurs_count,
            'filieres_count'         => $filieres_count,
            'etablissements_count'   => $etablissements_count,
            'evenements_count'       => $evenements_count,
            'users'                  => $users,
        ]);
    }
}
