<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Statistic\CountUserController;
use App\Controller\Statistic\NewUsersController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    collectionOperations: ['get_user' => [
        // Limit access to get item operation only if the logged user is one of:
        // - have ROLE_ADMIN
        'security' => ' is_granted("ROLE_STATS")',
        'method'   => 'GET',
        'path' => '/stats/user_number',
        'controller'=> CountUserController::class,
    ],'get_New_user' => [
        // Limit access to get item operation only if the logged user is one of:
        // - have ROLE_ADMIN
        'security' => ' is_granted("ROLE_STATS")',
        'method'   => 'GET',
        'path' => '/stats/new_user',
        'controller'=> NewUsersController::class,
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
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[
        Assert\NotBlank(
            message: 'user.email.NotBlank',
        ),
        Assert\Length(
            min: 5,
            max: 180,
            minMessage: 'user.email.minMessage' ,
            maxMessage: 'user.email.maxMessage' ,
        ),
    ]
    private ?string $email = null;


    #[ORM\Column(length: 180, unique: true)]
    #[
        Assert\NotBlank(
            message: 'user.email.NotBlank',
        ),
        Assert\Length(
            min: 2,
            max: 180,
            minMessage: 'user.username.minMessage' ,
            maxMessage: 'user.username.maxMessage' ,
        ),
    ]
    private ?string $username = null;


    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank(
            message: 'user.firstName.NotBlank',
        ),
        Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'user.firstName.minMessage' ,
            maxMessage: 'user.firstName.maxMessage' ,
        ),
    ]
    private ?string $firstName = null;

    #[ORM\Column(length: 50)]
    #[
        Assert\NotBlank(
            message: 'user.lastName.NotBlank',
        ),
        Assert\Length(
            min: 2,
            max: 50,
            minMessage: 'user.lastName.minMessage' ,
            maxMessage: 'user.lastName.maxMessage' ,
        ),
    ]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[
        Assert\NotBlank(
            message: 'user.dateOfBirth.NotBlank',
        ),
        Assert\LessThan(
            message: 'user.dateOfBirth.LessThan',
            value: ('-16 years'),
        ),
    ]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $registrationDate = null;

    #[ORM\ManyToOne(inversedBy: 'user')]
    private ?Gender $gender = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserPicture $userPicture = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Address $address = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Basket::class)]
    private Collection $basket;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Review::class)]
    private Collection $review;

  

    public function __construct()
    {
        $this->basket = new ArrayCollection();
        $this->review = new ArrayCollection();
      
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): self
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    public function getGender(): ?Gender
    {
        return $this->gender;
    }

    public function setGender(?Gender $gender): self
    {
        $this->gender = $gender;

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
            $this->userPicture->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($userPicture !== null && $userPicture->getUser() !== $this) {
            $userPicture->setUser($this);
        }

        $this->userPicture = $userPicture;

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

    /**
     * @return Collection<int, Basket>
     */
    public function getBasket(): Collection
    {
        return $this->basket;
    }

    public function addBasket(Basket $basket): self
    {
        if (!$this->basket->contains($basket)) {
            $this->basket[] = $basket;
            $basket->setUser($this);
        }

        return $this;
    }

    public function removeBasket(Basket $basket): self
    {
        if ($this->basket->removeElement($basket)) {
            // set the owning side to null (unless already changed)
            if ($basket->getUser() === $this) {
                $basket->setUser(null);
            }
        }

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
            $review->setUser($this);
        }

        return $this;
    }

    public function removeReview(Review $review): self
    {
        if ($this->review->removeElement($review)) {
            // set the owning side to null (unless already changed)
            if ($review->getUser() === $this) {
                $review->setUser(null);
            }
        }

        return $this;
    }

   
}
