<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        // Données fictives pour tester l'affichage (à remplacer par des entités Doctrine)
        $filieres = [
            ['id' => 1, 'nom' => 'Génie Logiciel', 'domaine' => 'Informatique', 'description' => 'Formation en développement logiciel, conception et architecture d\'applications.', 'duree' => 3, 'langue' => 'Français'],
            ['id' => 2, 'nom' => 'Réseaux & Télécoms', 'domaine' => 'Informatique', 'description' => 'Formation en administration réseau, sécurité informatique et télécommunications.', 'duree' => 3, 'langue' => 'Français'],
            ['id' => 3, 'nom' => 'Intelligence Artificielle', 'domaine' => 'Data Science', 'description' => 'Formation en machine learning, deep learning et traitement des données.', 'duree' => 2, 'langue' => 'Français'],
        ];

        $etablissements = [
            ['id' => 1, 'nom' => 'IP Net Institute', 'ville' => 'Lomé', 'description' => 'Institut de technologie de référence au Togo.', 'telephone' => '+228 90 00 00 00', 'filieres' => []],
            ['id' => 2, 'nom' => 'Université de Lomé', 'ville' => 'Lomé', 'description' => 'Plus grande université publique du Togo.', 'telephone' => '+228 22 21 35 00', 'filieres' => []],
            ['id' => 3, 'nom' => 'ESTIM', 'ville' => 'Lomé', 'description' => 'École supérieure de technologies de l\'information et du management.', 'telephone' => null, 'filieres' => []],
            ['id' => 4, 'nom' => 'IST', 'ville' => 'Lomé', 'description' => 'Institut supérieur de technologie.', 'telephone' => null, 'filieres' => []],
        ];

        return $this->render('front/home.html.twig', [
            'filieres' => $filieres,
            'etablissements' => $etablissements,
        ]);
    }
}
