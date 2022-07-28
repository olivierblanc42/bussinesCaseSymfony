<?php

namespace App\Entity;

use App\Repository\ProfilRelativePathRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRelativePathRepository::class)]
class ProfilRelativePath
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\OneToOne(mappedBy: 'profilRelativePath', cascade: ['persist', 'remove'])]
    private ?UserPicture $userPicture = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getUserPicture(): ?UserPicture
    {
        return $this->userPicture;
    }

    public function setUserPicture(?UserPicture $userPicture): self
    {
        // unset the owning side of the relation if necessary
        if ($userPicture === null && $this->userPicture !== null) {
            $this->userPicture->setProfilRelativePath(null);
        }

        // set the owning side of the relation if necessary
        if ($userPicture !== null && $userPicture->getProfilRelativePath() !== $this) {
            $userPicture->setProfilRelativePath($this);
        }

        $this->userPicture = $userPicture;

        return $this;
    }
}
