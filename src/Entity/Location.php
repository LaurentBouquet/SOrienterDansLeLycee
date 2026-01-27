<?php

namespace App\Entity;

use App\Repository\LocationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LocationRepository::class)]
#[ORM\Table(name: 'tbl_location')]
class Location
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $floor = null;

    #[ORM\Column(length: 50)]
    private ?string $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reference = null;

    /**
     * @var Collection<int, Connection>
     */
    #[ORM\OneToMany(targetEntity: Connection::class, mappedBy: 'locationA')]
    private Collection $connectionA;

    /**
     * @var Collection<int, Connection>
     */
    #[ORM\OneToMany(targetEntity: Connection::class, mappedBy: 'locationB')]
    private Collection $connectionB;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    public function __construct()
    {
        $this->connectionA = new ArrayCollection();
        $this->connectionB = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getFloor(): ?int
    {
        return $this->floor;
    }

    public function setFloor(int $floor): static
    {
        $this->floor = $floor;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(?string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection<int, Connection>
     */
    public function getConnectionA(): Collection
    {
        return $this->connectionA;
    }

    public function addConnectionA(Connection $connectionA): static
    {
        if (!$this->connectionA->contains($connectionA)) {
            $this->connectionA->add($connectionA);
            $connectionA->setLocationA($this);
        }

        return $this;
    }

    public function removeConnectionA(Connection $connectionA): static
    {
        if ($this->connectionA->removeElement($connectionA)) {
            // set the owning side to null (unless already changed)
            if ($connectionA->getLocationA() === $this) {
                $connectionA->setLocationA(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Connection>
     */
    public function getConnectionB(): Collection
    {
        return $this->connectionB;
    }

    public function addConnectionB(Connection $connectionB): static
    {
        if (!$this->connectionB->contains($connectionB)) {
            $this->connectionB->add($connectionB);
            $connectionB->setLocationB($this);
        }

        return $this;
    }

    public function removeConnectionB(Connection $connectionB): static
    {
        if ($this->connectionB->removeElement($connectionB)) {
            // set the owning side to null (unless already changed)
            if ($connectionB->getLocationB() === $this) {
                $connectionB->setLocationB(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): static
    {
        $this->image = $image;

        return $this;
    }
}
