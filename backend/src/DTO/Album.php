<?php

namespace App\DTO;

use App\Entity\AlbumEntity;
use App\Repository\AlbumEntityRepository;

class Album
{
    private $id;
    private $title;
    private $issueDate;
    public static function fromAlbumEntity(AlbumEntity $albumEntity): Album{
        $album = new self;
        $album->id = $albumEntity->getId();
        $album->title = $albumEntity->getTitle();
        $album->issueDate = $albumEntity->getIssueDate();
        return $album;
    }
    public function setTitle(string $title): void{
        $this->title = $title;
    }
    public function setIssueDate(string $issueDate): void{
        $this->issueDate= $issueDate;
    }
    public function getTitle(): string{
        return $this->title;
    }
    public function getIssueDate(): string{
        return $this->issueDate;
    }
}