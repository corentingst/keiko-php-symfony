<?php

namespace App\Components\Tunes;

use App\Repository\TuneEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TuneDeleter
{

    private $repository;
    private $entityManager;

    public function __construct(TuneEntityRepository $repository, EntityManagerInterface $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }
    public function  deleteTune(String $tuneId): void{
        $tuneToDelete = $this->repository->find($tuneId);
        $this->entityManager->remove($tuneToDelete);
        $this->entityManager->flush();
    }
}