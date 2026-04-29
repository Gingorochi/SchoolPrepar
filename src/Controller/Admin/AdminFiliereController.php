<?php

namespace App\Controller\Admin;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/filieres', name: 'admin_filiere_')]
class AdminFiliereController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(FiliereRepository $filiereRepository): Response
    {
        $filieres = $filiereRepository->findAll();
        return $this->render('admin/filiere/index.html.twig', [
            'filieres' => $filieres,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filiere);
            $entityManager->flush();

            $this->addFlash('success', 'Filière créée avec succès.');
            return $this->redirectToRoute('admin_filiere_index');
        }

        return $this->render('admin/filiere/new.html.twig', [
            'filiere' => $filiere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, Filiere $filiere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Filière mise à jour avec succès.');
            return $this->redirectToRoute('admin_filiere_index');
        }

        return $this->render('admin/filiere/edit.html.twig', [
            'filiere' => $filiere,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Filiere $filiere, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filiere->getId(), $request->request->get('_token'))) {
            $entityManager->remove($filiere);
            $entityManager->flush();
            $this->addFlash('success', 'Filière supprimée avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('admin_filiere_index');
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Filiere $filiere): Response
    {
        return $this->render('admin/filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }
}
