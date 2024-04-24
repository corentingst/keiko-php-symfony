<?php

namespace App\Components\Tunes;

use App\Repository\TuneEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TuneLister
{
    private $repository;

    public function __construct(TuneEntityRepository $repository)
    {
        $this->repository = $repository;
    }
    public function  listTunes(string $filterValue): array {
        $tuneList = $this->repository->filterByTitle($filterValue);
        return ($tuneList);
    }
}