<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AddressRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
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
class Address
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank,
        Assert\Length([
            'min' => 2,
            'max' => 50,
        ]),
    ]
    private ?string $line1 = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank,
        Assert\Length([
            'min' => 2,
            'max' => 50,
        ]),
    ]
    private ?string $line2 = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank,
        Assert\Length([
            'min' => 2,
            'max' => 50,
        ]),
    ]
    private ?string $line3 = null;

    #[ORM\Column(length: 100)]
    #[
        Assert\NotBlank,
        Assert\Length([
            'min' => 2,
            'max' => 100,
        ]),
    ]
    private ?string $city = null;

    #[ORM\Column(length: 10)]
    #[
        Assert\NotBlank,
        Assert\Length([
            'min' => 2,
            'max' => 10,
        ]),
    ]
    private ?string $postalCode = null;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'address', targetEntity: Basket::class)]
    private Collection $baskets;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->baskets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLine1(): ?string
    {
        return $this->line1;
    }

    public function setLine1(string $line1): self
    {
        $this->line1 = $line1;

        return $this;
    }

    public function getLine2(): ?string
    {
        return $this->line2;
    }

    public function setLine2(string $line2): self
    {
        $this->line2 = $line2;

        return $this;
    }

    public function getLine3(): ?string
    {
        return $this->line3;
    }

    public function setLine3(string $line3): self
    {
        $this->line3 = $line3;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setAddress($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAddress() === $this) {
                $user->setAddress(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Basket>
     */
    public function getBaskets(): Collection
    {
        return $this->baskets;
    }

    public function addBasket(Basket $basket): self
    {
        if (!$this->baskets->contains($basket)) {
            $this->baskets[] = $basket;
            $basket->setAddress($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): self
    {
        if ($this->baskets->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getAddress() === $this) {
                $basket->setAddress(null);
            }
        }

        return $this;
    }
}
