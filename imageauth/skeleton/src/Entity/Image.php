<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imageHolder = null;

    #[ORM\Column(length: 255)]
    private ?string $ImageFile = null;

    #[ORM\Column(length: 255)]
    private ?string $ImageName = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageHolder(): ?string
    {
        return $this->imageHolder;
    }

    public function setImageHolder(string $imageHolder): self
    {
        $this->imageHolder = $imageHolder;

        return $this;
    }

    public function getImageFile(): ?string
    {
        return $this->ImageFile;
    }

    public function setImageFile(string $ImageFile): self
    {
        $this->ImageFile = $ImageFile;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->ImageName;
    }

    public function setImageName(string $ImageName): self
    {
        $this->ImageName = $ImageName;

        return $this;
    }
}
