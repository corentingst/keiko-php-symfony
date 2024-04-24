<?php

namespace App\Components\Albums;

use App\DTO\Album;
use App\Repository\AlbumEntityRepository;

class AlbumRetriever
{
    public function __construct(
        private AlbumEntityRepository $repository,
    ){}
    public function getAlbum(string $albumId): Album {

        // fetch entity
        $entity = $this->repository->find($albumId);

        // return Tune object
        return Album::fromAlbumEntity($entity);
    }
}