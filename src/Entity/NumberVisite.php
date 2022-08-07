<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\Statistic\NumberOfVisitController;
use App\Repository\NumberVisiteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NumberVisiteRepository::class)]
#[ApiResource(
    collectionOperations: [        'get_recurance' => [
        // Limit access to get item operation only if the logged user is one of:
        // - have ROLE_ADMIN
        'security' => ' is_granted("ROLE_STATS")',
        'method' => 'GET',
        'path' => '/stats/number_visit',
        'controller' => NumberOfVisitController::class,
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
class NumberVisite
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column()]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $visitAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVisitAt(): ?\DateTimeInterface
    {
        return $this->visitAt;
    }

    public function setVisitAt(\DateTimeInterface $visitAt): self
    {
        $this->visitAt = $visitAt;

        return $this;
    }
}
