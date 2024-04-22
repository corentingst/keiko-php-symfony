<?php

namespace App\DTO;

class Tune
{
//    private $id;
//    private $title;
//    private $author;

    public ?string $id;
    public ?string $title;
    public ?string $author;
    public function __construct($id, $title, $author){
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
    }
    public function getId(): ?string
    {
        return $this->id;
    }
    public function getTitle(): ?string
    {
        return $this->title;
    }
    public function getAuthor(): ?string
    {
        return $this->author;
    }
    public function setId($tuneId): void
    {
        $id = $tuneId;
    }
    public function setTitle($tuneTitle): void
    {
        $title=$tuneTitle;
    }
    public function setAuthor($tuneAuthor): void
    {
        $author=$tuneAuthor;
    }
}