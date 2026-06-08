<?php

namespace App\Controller\Front;

use App\Entity\Etablissement;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etablissements', name: 'app_etablissement_')]
class EtablissementDetailController extends AbstractController
{
    #[Route('/{id}', name: 'show', requirements: ['id' => '\\d+'])]
    public function show(int $id, EtablissementRepository $etablissementRepository): Response
    {
        $etablissement = $etablissementRepository->find($id);

        if (!$etablissement) {
            throw $this->createNotFoundException('Établissement introuvable.');
        }

        return $this->render('front/etablissement/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }
}

