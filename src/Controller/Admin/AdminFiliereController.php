<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/filieres', name: 'admin_filiere_')]
class AdminFiliereController extends AbstractController
{
    private function getFakeFilieres(): array
    {
        return [
            ['id' => 1, 'nom' => 'Génie Logiciel', 'domaine' => 'Informatique', 'description' => 'Formation complète en développement logiciel, conception et architecture d\'applications modernes.', 'duree' => 3, 'langue' => 'Français'],
            ['id' => 2, 'nom' => 'Réseaux & Télécoms', 'domaine' => 'Informatique', 'description' => 'Formation en administration réseau, sécurité informatique et télécommunications.', 'duree' => 3, 'langue' => 'Français'],
            ['id' => 3, 'nom' => 'Intelligence Artificielle', 'domaine' => 'Data Science', 'description' => 'Formation avancée en machine learning, deep learning et traitement des données massives.', 'duree' => 2, 'langue' => 'Français'],
            ['id' => 4, 'nom' => 'Webmaster & Infographie', 'domaine' => 'Multimédia', 'description' => 'Formation en création web, design graphique et communication digitale.', 'duree' => 2, 'langue' => 'Français'],
        ];
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/filiere/index.html.twig', [
            'filieres' => $this->getFakeFilieres(),
        ]);
    }

    // Ces méthodes seront complétées au TP3 avec les formulaires Symfony
    #[Route('/new', name: 'new')]
    public function new(): Response
    {
        // TODO : créer un FormType et gérer la persistance Doctrine
        return new Response('Formulaire de création (à implémenter au TP3)');
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(int $id): Response
    {
        // TODO : pré-remplir le formulaire avec les données existantes
        return new Response("Formulaire d'édition pour la filière $id (à implémenter au TP3)");
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(int $id): Response
    {
        // TODO : supprimer l'entité et rediriger
        $this->addFlash('success', "Filière $id supprimée.");
        return $this->redirectToRoute('admin_filiere_index');
    }
}
