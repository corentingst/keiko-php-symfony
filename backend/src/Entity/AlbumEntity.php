<?php

namespace App\Entity;

use App\DTO\Album;
use App\Repository\AlbumEntityRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AlbumEntityRepository::class)]
class AlbumEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $issueDate = null;

    public static function fromAlbumToCreate(Album $albumToCreate): AlbumEntity{
        $entity = new self();
        $entity->title = $albumToCreate->getTitle();
        $entity->issueDate = $albumToCreate->getIssueDate();
        return $entity;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getIssueDate(): ?string
    {
        return $this->issueDate;
    }

    public function setIssueDate(string $issueDate): static
    {
        $this->issueDate = $issueDate;

        return $this;
    }
}
