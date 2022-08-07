<?php

namespace App\Entity;

use App\Repository\UserPictureRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPictureRepository::class)]
#[ApiResource(
    collectionOperations: [],
    itemOperations: [
        "get" => ["security" => "is_granted('ROLE_ADMIN')"],
        ]
)]
class UserPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank(
            message: 'userpicture.name.NotBlank',
        ),
        Assert\Length(
            min: 5,
            max: 50,
            minMessage: 'userpicture.name.minMessage' ,
            maxMessage: 'userpicture.name.maxMessage' ,
        ),
    ]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'userPicture', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank(
            message: 'userpicture.url.NotBlank',
        ),
        Assert\Length(
            min: 5,
            max: 255,
            minMessage: 'userpicture.url.minMessage' ,
            maxMessage: 'userpicture.url.maxMessage' ,
        ),
    ]
    private ?string $url = null;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;

        return $this;
    }

}
