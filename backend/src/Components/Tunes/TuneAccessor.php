<?php

namespace App\Components\Tunes;

use App\DTO\Tune;
use App\Repository\TuneEntityRepository;

class TuneAccessor
{
    private $repository;

    public function __construct(TuneEntityRepository $repository)
    {
        $this->repository = $repository;
    }
    public function  getTune(String $tuneId): Tune {
        // fetch entity
        $entity = $this->repository->find($tuneId);

        // return Tune object
        return Tune::fromTuneEntity($entity);
    }

}