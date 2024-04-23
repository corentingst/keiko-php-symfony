<?php

namespace App\DTO;

use App\Entity\TuneEntity;

class Tune
{
    private $id;
    private $title;
    private $author;
    public static function fromTuneEntity(TuneEntity $tuneEntity): self
    {
        $tune = new self();
        $tune->title = $tuneEntity->getTitle();
        $tune->author = $tuneEntity->getAuthor();
        return $tune;

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
        $this->id = $tuneId;
    }
    public function setTitle($tuneTitle): void
    {
        $this->title = $tuneTitle;
    }
    public function setAuthor($tuneAuthor): void
    {
        $this->author = $tuneAuthor;
    }
}