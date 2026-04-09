<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/etablissements', name: 'admin_etablissement_')]
class AdminEtablissementController extends AbstractController
{
    private function getFakeEtablissements(): array
    {
        return [
            ['id' => 1, 'nom' => 'IP Net Institute of Technology', 'ville' => 'Lomé', 'description' => 'Institut de technologie de référence au Togo.', 'telephone' => '+228 90 00 00 00', 'filieres' => [1, 2]],
            ['id' => 2, 'nom' => 'Université de Lomé', 'ville' => 'Lomé', 'description' => 'Plus grande université publique du Togo.', 'telephone' => '+228 22 21 35 00', 'filieres' => [1, 2, 3]],
            ['id' => 3, 'nom' => 'ESTIM', 'ville' => 'Lomé', 'description' => 'École supérieure de technologies de l\'information et du management.', 'telephone' => null, 'filieres' => [1, 4]],
            ['id' => 4, 'nom' => 'IST', 'ville' => 'Lomé', 'description' => 'Institut supérieur de technologie.', 'telephone' => null, 'filieres' => [2, 4]],
        ];
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/etablissement/index.html.twig', [
            'etablissements' => $this->getFakeEtablissements(),
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(): Response
    {
        // TODO : implémenter au TP3
        return new Response('Formulaire de création (à implémenter au TP3)');
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(int $id): Response
    {
        return new Response("Formulaire d'édition pour l'établissement $id (à implémenter au TP3)");
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(int $id): Response
    {
        $this->addFlash('success', "Établissement $id supprimé.");
        return $this->redirectToRoute('admin_etablissement_index');
    }
}
