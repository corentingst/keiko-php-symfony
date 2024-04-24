<?php

namespace App\Components\Albums;

use App\Repository\AlbumEntityRepository;

class AlbumLister
{
    public function __construct(private AlbumEntityRepository $repository){}
    public function  listAlbums(string $filterValue): array {
        $albumList = $this->repository->filterByTitle($filterValue);
        return ($albumList);
    }
}