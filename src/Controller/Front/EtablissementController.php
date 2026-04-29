<?php

namespace App\Controller\Front;

use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etablissements', name: 'app_etablissement_')]
class EtablissementController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(EtablissementRepository $etablissementRepository): Response
    {
        // Récupérer les vraies données de la base de données
        $etablissements = $etablissementRepository->findAll();

        return $this->render('front/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
}
