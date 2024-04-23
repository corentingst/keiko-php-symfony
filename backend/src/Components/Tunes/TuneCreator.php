<?php

namespace App\Components\Tunes;

use App\DTO\Tune;
use App\Entity\TuneEntity;
use App\Repository\TuneEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TuneCreator
{

    private $repository;
    private $entityManager;

    public function __construct(TuneEntityRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }
    public function  createTune(Tune $tuneToBeCreated): Tune {
        // Tune to Tune Entity
        $tuneEntity = TuneEntity::fromTune($tuneToBeCreated);

        // flush it to database
        $this->entityManager->persist($tuneEntity);
        $this->entityManager->flush();

        return Tune::fromTuneEntity($tuneEntity);
    }
}