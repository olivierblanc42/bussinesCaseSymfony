<?php

namespace App\Entity;

use App\Repository\PictureRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PictureRepository::class)]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank(
            message: 'name.path.NotBlank',
        ),
        Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'name.path.minMessage' ,
            maxMessage: 'name.path.maxMessage' ,
        ),
    ]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'picture')]
    private ?Product $product = null;

    #[ORM\Column(length: 500)]
    #[
        Assert\NotBlank(
            message: 'picture.path.NotBlank',
        ),
        Assert\Length(
            min: 2,
            max: 500,
            minMessage: 'picture.path.minMessage' ,
            maxMessage: 'picture.path.maxMessage' ,
        ),
    ]
    private ?string $path = null;

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
    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
