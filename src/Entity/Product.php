<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    collectionOperations: ['get', 'post'],
    itemOperations: ['get', 'put', 'delete'],
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $label = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isInstock = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    private ?string $priceHt = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Brand $brand = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Species $species = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?Category $category = null;

   

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Review::class)]
    private Collection $review;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: QuantityInBasket::class)]
    private Collection $quantityInBaskets;

    #[ORM\OneToMany(mappedBy: 'product', targetEntity: Picture::class)]
    private Collection $picture;


    public function __construct()
    {
        
        $this->review = new ArrayCollection();
        $this->quantityInBaskets = new ArrayCollection();
        $this->picture = new ArrayCollection();
       
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

 

    public function isIsInstock(): ?bool
    {
        return $this->isInstock;
    }

    public function setIsInstock(bool $isInstock): self
    {
        $this->isInstock = $isInstock;

        return $this;
    }

    public function isIsActive(): ?bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;

        return $this;
    }

    public function getPriceHt(): ?string
    {
        return $this->priceHt;
    }

    public function setPriceHt(string $priceHt): self
    {
        $this->priceHt = $priceHt;

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): self
    {
        $this->species = $species;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

 

    /**
     * @return Collection<int, Review>
     */
    public function getReview(): Collection
    {
        return $this->review;
    }

    public function addReview(Review $review): self
    {
        if (!$this->review->contains($review)) {
            $this->review[] = $review;
            $review->setProduct($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getProduct() === $this) {
                $review->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, QuantityInBasket>
     */
    public function getQuantityInBaskets(): Collection
    {
        return $this->quantityInBaskets;
    }

    public function addQuantityInBasket(QuantityInBasket $quantityInBasket): self
    {
        if (!$this->quantityInBaskets->contains($quantityInBasket)) {
            $this->quantityInBaskets[] = $quantityInBasket;
            $quantityInBasket->setProduct($this);
        }

        return $this;
    }

    public function removeQuantityInBasket(QuantityInBasket $quantityInBasket): self
    {
        if ($this->quantityInBaskets->removeElement($quantityInBasket)) {
            // set the owning side to null (unless already changed)
            if ($quantityInBasket->getProduct() === $this) {
                $quantityInBasket->setProduct(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Picture>
     */
    public function getPicture(): Collection
    {
        return $this->picture;
    }

    public function addPicture(Picture $picture): self
    {
        if (!$this->picture->contains($picture)) {
            $this->picture[] = $picture;
            $picture->setProduct($this);
        }

        return $this;
    }

    public function removePicture(Picture $picture): self
    {
        if ($this->picture->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getProduct() === $this) {
                $picture->setProduct(null);
            }
        }

        return $this;
    }

  
}
