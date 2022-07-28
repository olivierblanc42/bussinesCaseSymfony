<?php

namespace App\Entity;

use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
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
class Basket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreated = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $validationDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $invoiceDate = null;

    #[ORM\ManyToOne(inversedBy: 'basket')]
    private ?User $user = null;

  

    #[ORM\ManyToOne(inversedBy: 'baskets')]
    private ?Address $address = null;

    #[ORM\ManyToOne(inversedBy: 'baskets')]
    private ?MeansOfPayment $meansOfPayment = null;

    #[ORM\ManyToOne(inversedBy: 'baskets')]
    private ?CommandStatus $commandStatus = null;

    #[ORM\OneToMany(mappedBy: 'basket', targetEntity: QuantityInBasket::class)]
    private Collection $basketQuantityInBasket;

    public function __construct()
    {
        $this->basketQuantityInBasket = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getValidationDate(): ?\DateTimeInterface
    {
        return $this->validationDate;
    }

    public function setValidationDate(\DateTimeInterface $validationDate): self
    {
        $this->validationDate = $validationDate;

        return $this;
    }

    public function getInvoiceDate(): ?\DateTimeInterface
    {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(\DateTimeInterface $invoiceDate): self
    {
        $this->invoiceDate = $invoiceDate;

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



    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getMeansOfPayment(): ?MeansOfPayment
    {
        return $this->meansOfPayment;
    }

    public function setMeansOfPayment(?MeansOfPayment $meansOfPayment): self
    {
        $this->meansOfPayment = $meansOfPayment;

        return $this;
    }

    public function getCommandStatus(): ?CommandStatus
    {
        return $this->commandStatus;
    }

    public function setCommandStatus(?CommandStatus $commandStatus): self
    {
        $this->commandStatus = $commandStatus;

        return $this;
    }

    /**
     * @return Collection<int, QuantityInBasket>
     */
    public function getBasketQuantityInBasket(): Collection
    {
        return $this->basketQuantityInBasket;
    }

    public function addBasketQuantityInBasket(QuantityInBasket $basketQuantityInBasket): self
    {
        if (!$this->basketQuantityInBasket->contains($basketQuantityInBasket)) {
            $this->basketQuantityInBasket[] = $basketQuantityInBasket;
            $basketQuantityInBasket->setBasket($this);
        }

        return $this;
    }

    public function removeBasketQuantityInBasket(QuantityInBasket $basketQuantityInBasket): self
    {
        if ($this->basketQuantityInBasket->removeElement($basketQuantityInBasket)) {
            // set the owning side to null (unless already changed)
            if ($basketQuantityInBasket->getBasket() === $this) {
                $basketQuantityInBasket->setBasket(null);
            }
        }

        return $this;
    }
}
