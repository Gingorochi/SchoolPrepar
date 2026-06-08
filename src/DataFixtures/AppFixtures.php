<?php

namespace App\DataFixtures;

use App\Entity\Etablissement;
use App\Entity\Filiere;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        // ---- Données de base : Etablissements + Filières ----
        // NOTE: Ce fixture doit aussi créer au moins 1 compte User (admin) pour tester l'accès à /admin.

        // Créer des établissements
        $etablissement1 = new Etablissement();
        $etablissement1->setNom('Université de Lomé');
        $etablissement1->setVille('Lomé');
        $etablissement1->setDescription('Université publique de référence au Togo');
        $etablissement1->setTelephone('+228 01 02 03 04 05');
        $etablissement1->setEmail('contact@ul.tg');
        $etablissement1->setAdresse('Lomé, Togo');
        $etablissement1->setType('Université');
        $manager->persist($etablissement1);

        $etablissement2 = new Etablissement();
        $etablissement2->setNom('Institut National Polytechnique');
        $etablissement2->setVille('Kara');
        $etablissement2->setDescription('Institut polytechnique de formation supérieure');
        $etablissement2->setTelephone('+228 30 64 06 06');
        $etablissement2->setEmail('info@inp.tg');
        $etablissement2->setAdresse('BP 1093 Kara');
        $etablissement2->setType('Institut');
        $manager->persist($etablissement2);

        // Créer des filières
        $filiere1 = new Filiere();
        $filiere1->setNom('Informatique');
        $filiere1->setDomaine('Sciences et Technologies');
        $filiere1->setDescription('Formation en développement logiciel, réseaux et systèmes d\'information');
        $filiere1->setDuree(3);
        $filiere1->setLangue('Français');
        $filiere1->setImage('informatique.jpg');
        $manager->persist($filiere1);

        $filiere2 = new Filiere();
        $filiere2->setNom('Gestion');
        $filiere2->setDomaine('Sciences Economiques');
        $filiere2->setDescription('Formation en management, comptabilité et finance');
        $filiere2->setDuree(3);
        $filiere2->setLangue('Français');
        $filiere2->setImage('gestion.jpg');
        $manager->persist($filiere2);

        $filiere3 = new Filiere();
        $filiere3->setNom('Médecine');
        $filiere3->setDomaine('Sciences de la Santé');
        $filiere3->setDescription('Formation médicale complète');
        $filiere3->setDuree(7);
        $filiere3->setLangue('Français');
        $filiere3->setImage('medecine.jpg');
        $manager->persist($filiere3);

        // Créer au moins 1 utilisateur admin pour accéder à /admin
        // (email unique car Security provider charge par email)
        $admin = new User();
        $admin->setNom('Admin');
        $admin->setPrenom('SchoolPrepar');
        $admin->setEmail('admin@exemple.com');
        $admin->setRole('ADMIN');
        $admin->setTelephone('+228 00 00 00 00');
        // Le mot de passe doit être hashé pour PasswordCredentials
        $admin->setPassword(
            $this->userPasswordHasher->hashPassword($admin, 'Admin123!')
        );
        $manager->persist($admin);

        // Exemple de user standard
        $user = new User();
        $user->setNom('User');
        $user->setPrenom('SchoolPrepar');
        $user->setEmail('user@exemple.com');
        $user->setRole('USER');
        $user->setTelephone('+228 11 11 11 11');
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, 'User123!')
        );
        $manager->persist($user);

        $manager->flush();
    }
}

