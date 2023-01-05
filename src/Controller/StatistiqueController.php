<?php

namespace App\Controller;

use App\Entity\Destination;
use App\Service\StatistiqueService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stat')]
class StatistiqueController extends AbstractController
{
    #[Route('/', name: 'app_stat')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $destinations = $entityManager->getRepository(Destination::class)->findAll();
        return $this->render('statistique/index.html.twig', [
            'destinations' => $destinations,
        ]);
    }

    #[Route('/bydest', name: 'app_stat_bydest', methods: ['POST'])]
    public function searchByDestination(Request $request, StatistiqueService $statistiqueService) {
        $idDest = $request->request->get('destination');
        $result = $statistiqueService->getVolsByDestination($idDest);

        return $this->render('statistique/bydest.html.twig', [
            'destination' => $result['destination'],
            'vols' => $result['vols']
        ]);
    }
}
