<?php

namespace App\Components\Tunes;

use App\DTO\Tune;
use App\Entity\TuneEntity;
use App\Repository\TuneEntityRepository;

class TuneAccessor
{
    private $repository;

    public function __construct(TuneEntityRepository $repository)
    {
        $this->repository = $repository;
    }
    public function  getTuneEntity(String $tuneId): TuneEntity
    {
        return $this->repository->find($tuneId);
    }
    public function getTune(String $tuneId): Tune
    {
        return Tune::fromTuneEntity($this->getTuneEntity($tuneId));
    }
}