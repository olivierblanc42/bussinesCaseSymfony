<?php

namespace App\Entity;

use App\Repository\UserPictureRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserPictureRepository::class)]
class UserPicture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'userPicture', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\OneToOne(inversedBy: 'userPicture', cascade: ['persist', 'remove'])]
    private ?ProfilRelativePath $profilRelativePath = null;

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

    public function getProfilRelativePath(): ?ProfilRelativePath
    {
        return $this->profilRelativePath;
    }

    public function setProfilRelativePath(?ProfilRelativePath $profilRelativePath): self
    {
        $this->profilRelativePath = $profilRelativePath;

        return $this;
    }
}
