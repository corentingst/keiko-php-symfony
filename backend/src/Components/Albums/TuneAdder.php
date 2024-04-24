<?php

namespace App\Components\Albums;

use App\Components\Tunes\TuneAccessor;
use App\Repository\AlbumEntityRepository;
use App\Repository\TuneEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class TuneAdder
{
    public function __construct(
        private AlbumEntityRepository $albumRepository,
        private TuneEntityRepository $tuneRepository,
        private EntityManagerInterface $entityManager,
        private AlbumRetriever $albumRetriever,
        private TuneAccessor $tuneAccessor,
    ){}
    public function addTuneToAlbum(string $tuneId, string $albumId): void
    {
        $albumEntity = $this->albumRetriever->getAlbumEntity($albumId);
        $tuneEntity = $this->tuneAccessor->getTuneEntity($tuneId);

        $albumEntity->addTune($tuneEntity);
        $this->entityManager->persist($albumEntity);
        $this->entityManager->flush();
    }
}