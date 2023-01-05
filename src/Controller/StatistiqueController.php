<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Entity\Destination;
use App\Entity\Vol;
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
    public function searchByDestination(Request $request, EntityManagerInterface $entityManager) {
        $idDest = $request->request->get('destination');
        $destination = $entityManager->getRepository(Destination::class)->find($idDest);
        $vols = $entityManager->getRepository(Vol::class)->findBy(['destination' => $destination]);
        return $this->render('statistique/bydest.html.twig', [
            'destination' => $destination,
            'vols' => $vols
        ]);
    }
}
