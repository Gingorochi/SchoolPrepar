<?php

namespace App\Controller;

use App\Entity\Etablissement;
use App\Entity\Filiere;
use App\Entity\User;
use App\Repository\EtablissementRepository;
use App\Repository\FiliereRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        if ($this->getUser()) {
            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('admin_dashboard');
            }

            return $this->redirectToRoute('app_home');
        }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        $adminMissing = $userRepository->findAdmin() === null;

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
            'admin_missing' => $adminMissing,
        ]);
    }

    #[Route(path: '/create-admin', name: 'app_create_admin', methods: ['POST'])]
    public function createAdmin(UserRepository $userRepository, EtablissementRepository $etablissementRepository, FiliereRepository $filiereRepository, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): RedirectResponse
    {
        if ($userRepository->findAdmin()) {
            return $this->redirectToRoute('app_login');
        }

        $etablissement = $etablissementRepository->findOneBy([]);
        if (!$etablissement) {
            $etablissement = new Etablissement();
            $etablissement->setNom('Établissement Admin');
            $etablissement->setVille('Lomé');
            $etablissement->setDescription('Établissement de service pour l\'administrateur');
            $etablissement->setTelephone('+22800000000');
            $etablissement->setEmail('admin@exemple.com');
            $etablissement->setAdresse('Lomé, Togo');
            $etablissement->setType('Centre de formation');
            $entityManager->persist($etablissement);
        }

        $filiere = $filiereRepository->findOneBy([]);
        if (!$filiere) {
            $filiere = new Filiere();
            $filiere->setNom('Filière Admin');
            $filiere->setDomaine('Administration');
            $filiere->setDescription('Filière de service pour l\'administrateur');
            $filiere->setDuree(1);
            $filiere->setLangue('Français');
            $filiere->setImage(null);
            $entityManager->persist($filiere);
        }

        $admin = new User();
        $admin->setNom('Admin');
        $admin->setPrenom('SchoolPrepar');
        $admin->setEmail('admin@exemple.com');
        $admin->setRole('ADMIN');
        $admin->setTelephone('+22800000000');
        $admin->setPassword($passwordHasher->hashPassword($admin, 'Admin123!'));
        $admin->setEtablissement($etablissement);
        $admin->setFiliere($filiere);

        $entityManager->persist($admin);
        $entityManager->flush();

        $this->addFlash('success', 'Compte admin créé avec succès. Utilisez admin@exemple.com / Admin123!.');

        return $this->redirectToRoute('app_login');
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}