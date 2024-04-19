<?php

namespace App\DTO;

class Tune
{
    private $id;
    private $title;
    private $author;
    public function getId(): ?int
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
}