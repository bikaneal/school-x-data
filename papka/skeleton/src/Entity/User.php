<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiFilter;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Image;
use DateTimeInterface;
use App\Controller\GetUserController;
use App\Controller\CreateImageController;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Delete;

use Doctrine\Common\Collections\Collection;
use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\HasLifecycleCallbacks]
#[
    ApiResource(operations:[
    new Post (
        uriTemplate: 'users',
        denormalizationContext: ['groups' => 'createUser']
    ),
    new Get(),
    new GetCollection(),
    new Patch(),
    new Delete()
    ]),
    ApiFilter(OrderFilter::class, properties: ['id', 'createdAt'], arguments: ['orderParameterName' => 'order']),
    ApiFilter(SearchFilter::class, properties: ['id' => SearchFilter::STRATEGY_EXACT]),
    ApiFilter(DateFilter::class, properties: ['createdAt'])
]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    #[Groups('createUser')]
    private string $name;

    #[ORM\Column(type: Types::TEXT, nullable: false)]
    #[Groups('createUser')]
    private string $surname;

    #[ORM\OneToMany(targetEntity: Image::class, mappedBy: "user")]
    private $imageHolder;

    #[ORM\Column (type: "datetime")]
    private $createdAt;

    #[ORM\Column (type: "datetime")]
    private $updatedAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $timestamp): self
    {
        $this->createdAt = $timestamp;
        return $this;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setCreatedAtAutomatically()
    {
        $this->setUpdatedAt(new \DateTime('now'));

        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }

    public function setSurname(string $surname): self
    {
        $this->surname = $surname;

        return $this;
    }

    public function getImageHolder(): ?Collection
    {
        return $this->imageHolder;
    }

    public function setImageHolder(collection $imageHolder): self
    {
        $this->imageHolder = $imageHolder;

        return $this;
    }
}
