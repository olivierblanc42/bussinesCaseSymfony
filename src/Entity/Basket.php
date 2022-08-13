<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Statistic\AverageBasketAbandonnedController;
use App\Controller\Statistic\AverageBasketPriceController;
use App\Controller\Statistic\BasketCanceledController;
use App\Controller\Statistic\BasketincommandController;
use App\Controller\Statistic\BasketNewClientConvertionController;
use App\Controller\Statistic\NumberOfBasketController;
use App\Controller\Statistic\RecurciveController;
use App\Controller\Statistic\TotalOfCommandController;
use App\Controller\Statistic\TotalSalesController;
use App\Repository\BasketRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BasketRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get_basket' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/basket_number',
            'controller' => NumberOfBasketController::class,
        ],
        'get_command' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/command_number',
            'controller' => TotalOfCommandController::class,
        ],
        'get_sales' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/total_sales',
            'controller' => TotalSalesController::class,
        ],
        'get_cancel' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/number_Of_Basket_Cancel',
            'controller' => BasketCanceledController::class,
        ],
        'get_average' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/basket_average_value',
            'controller' => AverageBasketPriceController::class,
        ],
        'get_abbandoned' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/basket_abbandoned',
            'controller' => AverageBasketAbandonnedController::class,
        ],
        'get_command_average' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/basket_in_command',
            'controller' => BasketincommandController::class,
        ],
        'get_visit_basket' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/conversion_basket_client',
            'controller' => BasketNewClientConvertionController::class,
        ],
        'get_recurance' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/recurance',
            'controller' => RecurciveController::class,
        ],
    ],

    itemOperations: [
        'get' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => '
        is_granted("ROLE_ADMIN")  or  is_granted("ROLE_STATS")
    ',],

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


    #[ORM\ManyToOne(targetEntity: Address::class, inversedBy: 'baskets')]
    private ?Address $address = null;

    #[ORM\ManyToOne(inversedBy: 'baskets' )]
    private ?MeansOfPayment $meansOfPayment = null;

    #[ORM\ManyToOne( targetEntity: CommandStatus::class, inversedBy: 'baskets')]
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
