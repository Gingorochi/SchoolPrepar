<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/filieres', name: 'app_filiere_')]
class FiliereController extends AbstractController
{
    // Données fictives centralisées (à remplacer par Doctrine plus tard)
    private function getFakeFilieres(): array
    {
        return [
            ['id' => 1, 'nom' => 'Génie Logiciel', 'domaine' => 'Informatique', 'description' => 'Formation complète en développement logiciel, couvrant la conception, l\'architecture et le déploiement d\'applications modernes. Les étudiants apprennent les langages orientés objets, les frameworks web, les bases de données et les bonnes pratiques de génie logiciel.', 'duree' => 3, 'langue' => 'Français', 'debouches' => ['Développeur Full-Stack', 'Architecte logiciel', 'Chef de projet IT', 'Ingénieur DevOps'], 'etablissements' => ['IP Net', 'ESTIM']],
            ['id' => 2, 'nom' => 'Réseaux & Télécoms', 'domaine' => 'Informatique', 'description' => 'Formation spécialisée en administration réseau, sécurité informatique et télécommunications. Le programme couvre les protocoles réseau, la cybersécurité, la virtualisation et les infrastructures cloud.', 'duree' => 3, 'langue' => 'Français', 'debouches' => ['Administrateur réseau', 'Ingénieur cybersécurité', 'Technicien télécom', 'Consultant IT'], 'etablissements' => ['IP Net', 'IST']],
            ['id' => 3, 'nom' => 'Intelligence Artificielle', 'domaine' => 'Data Science', 'description' => 'Formation avancée en machine learning, deep learning et traitement des données massives. Les étudiants maîtrisent Python, TensorFlow, les algorithmes de ML et la visualisation de données.', 'duree' => 2, 'langue' => 'Français', 'debouches' => ['Data Scientist', 'Ingénieur ML', 'Analyste données', 'Chercheur en IA'], 'etablissements' => ['Université de Lomé']],
            ['id' => 4, 'nom' => 'Webmaster & Infographie', 'domaine' => 'Multimédia', 'description' => 'Formation en création web, design graphique et communication digitale. Les étudiants apprennent HTML/CSS, JavaScript, les CMS, Adobe Creative Suite et le marketing digital.', 'duree' => 2, 'langue' => 'Français', 'debouches' => ['Webdesigner', 'Infographiste', 'Community manager', 'UX/UI Designer'], 'etablissements' => ['ESTIM', 'IST']],
        ];
    }

    #[Route('', name: 'index')]
    public function index(): Response
    {
        return $this->render('front/filiere/index.html.twig', [
            'filieres' => $this->getFakeFilieres(),
        ]);
    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id): Response
    {
        $filieres = $this->getFakeFilieres();

        // Chercher la filière par id
        $filiere = null;
        foreach ($filieres as $f) {
            if ($f['id'] === $id) {
                $filiere = $f;
                break;
            }
        }

        if (!$filiere) {
            throw $this->createNotFoundException('Filière introuvable.');
        }

        return $this->render('front/filiere/show.html.twig', [
            'filiere' => $filiere,
        ]);
    }
}
