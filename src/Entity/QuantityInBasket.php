<?php

namespace App\Entity;

use App\Repository\QuantityInBasketRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: QuantityInBasketRepository::class)]
#[ApiResource(
    collectionOperations: ['get' => [
        // Limit access to get item operation only if the logged user is one of:
        // - have ROLE_ADMIN
        'security' => '
            is_granted("ROLE_ADMIN")
        ',
    ],
],
itemOperations: [
    'get' => [
    // Limit access to get item operation only if the logged user is one of:
    // - have ROLE_ADMIN
    'security' => '
        is_granted("ROLE_ADMIN")
    ',
    ],
],
)]
class QuantityInBasket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'basketQuantityInBasket')]
    private ?Basket $basket = null;

    #[ORM\ManyToOne(inversedBy: 'quantityInBaskets')]
    private ?Product $product = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2, nullable: true)]
    private ?string $price = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getBasket(): ?Basket
    {
        return $this->basket;
    }

    public function setBasket(?Basket $basket): self
    {
        $this->basket = $basket;

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

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }
}
