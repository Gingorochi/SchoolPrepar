<?php

namespace App\Controller\Front;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etablissements', name: 'app_etablissement_')]
class EtablissementController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        $etablissements = [
            ['id' => 1, 'nom' => 'IP Net Institute of Technology', 'ville' => 'Lomé', 'description' => 'Institut de technologie de référence au Togo, formant les professionnels du numérique depuis plusieurs années.', 'telephone' => '+228 90 00 00 00', 'filieres' => [1, 2]],
            ['id' => 2, 'nom' => 'Université de Lomé', 'ville' => 'Lomé', 'description' => 'Plus grande université publique du Togo, proposant une large gamme de formations académiques et professionnelles.', 'telephone' => '+228 22 21 35 00', 'filieres' => [1, 2, 3]],
            ['id' => 3, 'nom' => 'ESTIM', 'ville' => 'Lomé', 'description' => 'École supérieure de technologies de l\'information et du management, axée sur les métiers du numérique.', 'telephone' => null, 'filieres' => [1, 4]],
            ['id' => 4, 'nom' => 'IST', 'ville' => 'Lomé', 'description' => 'Institut supérieur de technologie proposant des formations courtes et professionnalisantes dans les filières techniques.', 'telephone' => null, 'filieres' => [2, 4]],
        ];

        return $this->render('front/etablissement/index.html.twig', [
            'etablissements' => $etablissements,
        ]);
    }
}
