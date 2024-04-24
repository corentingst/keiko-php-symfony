<?php

namespace App\Components\Albums;

use App\DTO\Album;
use App\Entity\AlbumEntity;
use App\Repository\AlbumEntityRepository;
use Doctrine\ORM\EntityManagerInterface;

class AlbumCreator
{
    public function __construct(
        private AlbumEntityRepository $repository,
        private EntityManagerInterface $entityManager
    ){}

    public function createAlbum(Album $albumToCreate): Album {
        // Album to Album Entity
        $albumEntity = AlbumEntity::fromAlbumToCreate($albumToCreate);

        // flush it to database
        $this->entityManager->persist($albumEntity);
        $this->entityManager->flush();

        return Album::fromAlbumEntity($albumEntity);
    }
}