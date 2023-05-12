<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\Delete;
use App\Repository\ImageRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Entity\User;
use DateTimeInterface;
use ApiPlatform\OpenApi\Model;
use App\Controller\CreateImageController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['media_object:read']],
    types: ['https://schema.org/MediaObject'],
    operations:[
        new Get(),
        new Delete(),
        new GetCollection(),
        new Post(
            controller: CreateImageController::class,
            deserialize: false,
            validationContext: ['groups' => ['Default', 'media_object_create']], 
            openapi: new Model\Operation(
                requestBody: new Model\RequestBody(
                    content: new \ArrayObject([
                        'multipart/form-data' => [
                            'schema' => [
                                'type' => 'object', 
                                'properties' => [
                                    'file' => [
                                        'type' => 'string', 
                                        'format' => 'binary'
                                    ]
                                ]
                            ]
                        ]
                    ])
                )
            )
        )
]),
    ApiFilter(OrderFilter::class, properties: ['id', 'createdAt'], arguments: ['orderParameterName' => 'order']),
    ApiFilter(SearchFilter::class, properties: ['id' => SearchFilter::STRATEGY_EXACT]),
    ApiFilter(DateFilter::class, properties: ['createdAt'])
]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ApiProperty(types: ['https://schema.org/contentUrl'])]
    #[Groups(['media_object:read'])]
    public ?string $contentUrl = null;

    #[Vich\UploadableField(mapping: "images", fileNameProperty: "filePath")]
    #[Assert\NotNull(groups: ['media_object_create'])]
    public ?File $file = null;

    #[ORM\Column(nullable: true)] 
    public ?string $filePath = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "imageHolder")]
    private $user;

    #[ORM\Column (type: "datetime")]
    #[Groups(['media_object:read'])]
    private $createdAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $timestamp): self
    {
        $this->createdAt = $timestamp;
        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtAutomatically()
    {
        if ($this->getCreatedAt() === null) {
            $this->setCreatedAt(new \DateTime());
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(int $user): self
    {
        $this->user = $user;

        return $this;
    }
}


