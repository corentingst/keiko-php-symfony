<?php

namespace App\Components\Albums;

use App\DTO\Album;
use App\Entity\AlbumEntity;
use App\Repository\AlbumEntityRepository;

class AlbumRetriever
{
    public function __construct(
        private AlbumEntityRepository $repository,
    ){}
    public function getAlbumEntity(string $albumId): AlbumEntity
    {
        return $this->repository->find($albumId);
    }
    public function getAlbum(string $albumId): Album
    {
        return Album::fromAlbumEntity($this->getAlbumEntity($albumId));
    }
}