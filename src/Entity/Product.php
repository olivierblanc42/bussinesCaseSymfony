<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Statistic\BestSellingController;
use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource(
    collectionOperations: ['get' => [
        // Limit access to get item operation only if the logged user is one of:
        // - have ROLE_ADMIN
        'security' => '
            is_granted("ROLE_ADMIN") or  is_granted("ROLE_STATS")
        ',
    ],
        'get_best_product' => [
            // Limit access to get item operation only if the logged user is one of:
            // - have ROLE_ADMIN
            'security' => ' is_granted("ROLE_STATS")',
            'method' => 'GET',
            'path' => '/stats/best_product',
            'controller' => BestSellingController::class,
        ],


],
itemOperations: [
    'get' => [
    // Limit access to get item operation only if the logged user is one of:
    // - have ROLE_ADMIN
    'security' => '
        is_granted("ROLE_ADMIN") or  is_granted("ROLE_STATS")
    ',
    ],
],
)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    #[
        Assert\NotBlank(
            message: 'product.label.NotBlank',
        ),
        Assert\Length(
            min: 5,
            max: 60,
            minMessage: 'product.label.minMessage' ,
            maxMessage: 'product.label.maxMessage' ,
        ),
    ]
    private ?string $label = null;

    #[ORM\Column(length: 300, nullable: true)]
    #[
        Assert\NotBlank(
            message: 'product.description.NotBlank',
        ),
        Assert\Length(
            min: 5,
            max: 60,
            minMessage: 'product.description.minMessage' ,
            maxMessage: 'product.description.maxMessage' ,
        ),
    ]
    private ?string $description = null;

    #[ORM\Column]
    #[
        Assert\GreaterThan(
            value:0,
            message: 'product.quantityInStock.GreaterThan',
        ),
    ]
    private ?int $quantityInStock = null;

    #[ORM\Column]
    private ?bool $isActive = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 8, scale: 2)]
    #[
        Assert\GreaterThan(
            value:10,
            message: 'product.priceHt.GreaterThan',
        ),
    ]
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

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'Favorite')]
    private Collection $users;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    public function __construct()
    {
        
        $this->review = new ArrayCollection();
        $this->quantityInBaskets = new ArrayCollection();
        $this->picture = new ArrayCollection();
        $this->users = new ArrayCollection();
       
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

 

    public function isQuantityInStock(): ?int
    {
        return $this->quantityInStock;
    }

    public function setQuantityInStock(int $quantityInStock): self
    {
        $this->quantityInStock = $quantityInStock;

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
            $user->addFavorite($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFavorite($this);
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }
  
}
