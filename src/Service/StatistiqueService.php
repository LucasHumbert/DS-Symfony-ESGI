<?php

namespace App\Service;


use App\Entity\Avion;
use App\Entity\Destination;
use App\Entity\Vol;
use Doctrine\ORM\EntityManager;

class StatistiqueService
{
    private $em;

    /**
     * @param $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }


    public function getVolsByDestination($id)
    {
        $destination = $this->em->getRepository(Destination::class)->find($id);
        $vols = $this->em->getRepository(Vol::class)->findBy(['destination' => $destination]);

        return ['destination' => $destination, 'vols' => $vols];
    }

    public function getAvionsEnService() {
        return $this->em->getRepository(Avion::class)->findBy(['enService' => 1]);
    }
}