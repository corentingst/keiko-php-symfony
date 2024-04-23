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
    public function  listTunes(string $filter): array {
        $tuneList = $this->repository->createQueryBuilder('p')->where("p.title LIKE '%{$filter}%'")->getQuery()->execute();
        return ($tuneList);
    }
}