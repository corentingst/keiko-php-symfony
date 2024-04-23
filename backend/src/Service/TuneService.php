<?php

namespace App\Service;

use App\DTO\Tune;
use App\Entity\TuneEntity;
use App\Repository\TuneEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TuneService
{
    private $repository;
    private $entityManager;

    public function __construct(TuneEntityRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }
    public function  getTune(String $tuneId): Tune {
//        // Instancier un nouvel objet Tune
//        $tune = new Tune();
//
//        // Utiliser des méthodes de l'objet Tune
//        $tune->setId('OI');
//        $tune->setTitle('My Tune');
//        $tune->setAuthor('John Doe');
//
//        return new Response($tune);


        // fetch entity
        $entity = $this->repository->find($tuneId);

        return new Tune($entity->getId(), $entity->getTitle(), $entity->getAuthor());
//        return new Tune(1, 'Tune 1', 'Artist 1');
    }
    public function  createTune(Tune $tuneToBeCreated): Tune {

        // tune to Tune Entity !!
        $entity = new TuneEntity();
        $entity->setTitle($tuneToBeCreated->getTitle());
        $entity->setAuthor($tuneToBeCreated->getAuthor());

        // flush it to database
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $tuneToBeCreated;
    }
    public function  deleteTune(String $tuneId): void{
        $tuneToDelete = $this->repository->find($tuneId);
        $this->entityManager->remove($tuneToDelete);
        $this->entityManager->flush();
    }
    public function  listTunes(): array {
        $tuneList = $this->repository->createQueryBuilder('p')->getQuery()->execute();
        return ([$tuneList]);
    }
}