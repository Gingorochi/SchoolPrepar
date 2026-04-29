<?php

namespace App\Controller\Front;

use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/filieres', name: 'app_filiere_')]
class FiliereController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(FiliereRepository $filiereRepository): Response
    {
        // Récupérer les vraies données de la base de données
        $filieres = $filiereRepository->findAll();

        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $filieres,
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id, FiliereRepository $filiereRepository): Response
    {
        // Récupérer la filière par id depuis la base de données
        $filiere = $filiereRepository->find($id);

        if (!$filiere) {
            throw $this->createNotFoundException('Filière introuvable.');
        }

        return $this->render('front/filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }
}
