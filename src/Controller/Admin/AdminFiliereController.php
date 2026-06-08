<?php

namespace App\Controller\Admin;

use App\Entity\Filiere;
use App\Form\FiliereType;
use App\Repository\FiliereRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/filieres', name: 'admin_filiere_')]
class AdminFiliereController extends AbstractController
{
    #[Route('', name: 'index')]
    #[IsGranted('ROLE_ADMIN')]
    public function index(FiliereRepository $filiereRepository): Response
    {
        $filieres = $filiereRepository->findAll();
        return $this->render('admin/filiere/index.html.twig', [
            'filieres' => $filieres,
        ]);
    }

    #[Route('/new', name: 'new')]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filiere = new Filiere();
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $filiere->getImageFile();

            if ($imageFile) {
                $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads/filieres';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', $originalName) ?? 'image';
                $newFilename = $safeName.'-'.uniqid('', true).'.'.$imageFile->guessExtension();

                $imageFile->move($uploadDir, $newFilename);
                $filiere->setImage($newFilename);
                $filiere->setImageFile(null);
            }

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
    #[IsGranted('ROLE_ADMIN')]
    public function edit(Request $request, Filiere $filiere, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FiliereType::class, $filiere);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $filiere->getImageFile();

            if ($imageFile) {
                $uploadDir = $this->getParameter('kernel.project_dir').'/public/uploads/filieres';
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                $originalName = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeName = preg_replace('/[^a-zA-Z0-9_-]+/', '-', $originalName) ?? 'image';
                $newFilename = $safeName.'-'.uniqid('', true).'.'.$imageFile->guessExtension();

                $imageFile->move($uploadDir, $newFilename);
                $filiere->setImage($newFilename);
                $filiere->setImageFile(null);
            }

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
    #[IsGranted('ROLE_ADMIN')]
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
    #[IsGranted('ROLE_ADMIN')]
    public function show(Filiere $filiere): Response
    {
        return $this->render('admin/filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }
}
