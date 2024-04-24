<?php

namespace App\Components\Albums;

use App\DTO\Album;
use App\DTO\Tune;
use App\Repository\AlbumEntityRepository;
use App\Repository\TuneEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TuneAdder
{
    public function __construct(
        private AlbumEntityRepository $albumRepository,
        private TuneEntityRepository $tuneRepository,
        private EntityManagerInterface $entityManager,
    ){}
    public function addTuneToAlbum(string $tuneId, string $albumId): void
    {
        $albumEntity = $this->albumRepository->find($albumId);
        $tuneEntity = $this->tuneRepository->find($tuneId);
        // a changer en utilisant un service retrieve entity

        $albumEntity->addTune($tuneEntity);
        $this->entityManager->persist($albumEntity);
        $this->entityManager->flush();
    }
}