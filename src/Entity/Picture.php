<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureRepository::class)]

class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'picture')]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'pictures')]
    private ?RelativePath $url = null;

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

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getUrl(): ?RelativePath
    {
        return $this->url;
    }

    public function setUrl(?RelativePath $url): self
    {
        $this->url = $url;

        return $this;
    }
}
