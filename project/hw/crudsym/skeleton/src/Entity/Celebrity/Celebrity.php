<?php

namespace App\Entity\Celebrity;

use ApiPlatform\Metadata\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use App\Controller\GetCelebrity;
use App\Controller\GetCelebrities;
use App\Controller\PostCelebrity;
use App\Controller\DeleteCelebrity;
use App\Controller\PatchCelebrity;
use App\Controller\PutCelebrity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ApiResource(operations: [
    new Get(
        name: 'GetCelebrity',
        uriTemplate: '/celebrities/{id}',
        requirements: ['id' => '\d+'],
        controller: GetCelebrity::class
    ),
    new GetCollection(
        name: 'GetCelebrities',
        uriTemplate: '/celebrities/',
        controller: GetCelebrities::class
    ),
    new Post(
        name: 'CreateCelebrity',
        uriTemplate: '/celebrities/',
        controller: PostCelebrity::class,
        deserialize: false
    ),
    new Patch(
        name: 'PatchCelebrity',
        uriTemplate: '/celebrities/{id}',
        controller: PatchCelebrity::class
    ),
    new Put(
        name: 'PutCelebrity',
        uriTemplate: '/celebrities/{id}',
        controller: PutCelebrity::class
    ),
    new Delete(
        name: 'DeleteCelebrity',
        uriTemplate: '/celebrities/{id}',
        controller: DeleteCelebrity::class
    )
],
normalizationContext: ['groups' => ['Celebrity']]
)]
#[ORM\Entity]
class Celebrity
{
    #[ORM\Id]
    #[ORM\Column (type: "integer")]
    #[ORM\GeneratedValue(strategy: "AUTO")]
    private int $id;

    #[ORM\Column (type: Types:: STRING, nullable: false)]
    #[Groups('Celebrity')]
    private string $name;

    #[ORM\Column (type: Types:: STRING, nullable: false)]
    #[Groups('Celebrity')]
    private string $surname;

    #[ORM\Column (type: Types:: INTEGER, nullable: false)]
    #[Groups('Celebrity')]
    private int $income;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getIncome(): ?int
    {
        return $this->income;
    }

    public function setIncome($income)
    {
        $this->income = $income;
    }

    public function __toString(){
        return $this->name;
        return $this->surname;
    }

}