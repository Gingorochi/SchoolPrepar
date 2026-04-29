<?php

namespace App\Controller\Admin;

use App\Entity\Etablissement;
use App\Form\EtablissementType;
use App\Repository\EtablissementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/admin/etablissements', name: 'admin_etablissement_')]
class AdminEtablissementController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(EtablissementRepository $etablissementRepository): Response
    {
        $etablissements = $etablissementRepository->findAll();
        return $this->render('admin/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $etablissement = new Etablissement();
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($etablissement);
            $entityManager->flush();

            $this->addFlash('success', 'Établissement créé avec succès.');
            return $this->redirectToRoute('admin_etablissement_index');
        }

        return $this->render('admin/etablissement/new.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit', requirements: ['id' => '\d+'])]
    public function edit(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EtablissementType::class, $etablissement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Établissement mis à jour avec succès.');
            return $this->redirectToRoute('admin_etablissement_index');
        }

        return $this->render('admin/etablissement/edit.html.twig', [
            'etablissement' => $etablissement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/delete', name: 'delete', methods: ['POST'], requirements: ['id' => '\d+'])]
    public function delete(Request $request, Etablissement $etablissement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etablissement->getId(), $request->request->get('_token'))) {
            $entityManager->remove($etablissement);
            $entityManager->flush();
            $this->addFlash('success', 'Établissement supprimé avec succès.');
        } else {
            $this->addFlash('error', 'Token CSRF invalide.');
        }

        return $this->redirectToRoute('admin_etablissement_index');
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(Etablissement $etablissement): Response
    {
        return $this->render('admin/etablissement/show.html.twig', [
            'etablissement' => $etablissement,
        ]);
    }
}
