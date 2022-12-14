<?php

namespace App\Entity;

use App\Repository\CommandStatusRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommandStatusRepository::class)]
#[ApiResource(
    collectionOperations: ['get' => [
        // Limit access to get item operation only if the logged user is one of:
        // - have ROLE_ADMIN
        'security' => '
            is_granted("ROLE_ADMIN")  or  is_granted("ROLE_STATS")
        ',
    ],
],
itemOperations: [
    'get' => [
    // Limit access to get item operation only if the logged user is one of:
    // - have ROLE_ADMIN
    'security' => '
        is_granted("ROLE_ADMIN")  or  is_granted("ROLE_STATS")
    ',
    ],
],
)]
class CommandStatus
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[
        Assert\NotBlank,
        Assert\Length([
            'min' => 2,
            'max' => 255,
        ]),
    ]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'commandStatus', targetEntity: Basket::class)]
    private Collection $baskets;

    public function __construct()
    {
        $this->baskets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

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
            $basket->setCommandStatus($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): self
    {
        if ($this->baskets->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getCommandStatus() === $this) {
                $basket->setCommandStatus(null);
            }
        }

        return $this;
    }
}
