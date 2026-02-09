<?php

namespace App\Entity;

use App\Repository\ConnectionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConnectionRepository::class)]
#[ORM\Table(name: 'tbl_connection')]
class Connection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'connectionA')]
    #[ORM\JoinColumn(nullable: false, name: 'location_a_id')]
    private ?Location $locationA = null;

    #[ORM\ManyToOne(inversedBy: 'connectionB')]
    #[ORM\JoinColumn(nullable: false, name: 'location_b_id')]
    private ?Location $locationB = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column]
    private ?bool $pmr = null;

    #[ORM\Column(type: Types::TEXT, name: 'instruction_a_to_b')]
    private ?string $instructionAtoB = null;

    #[ORM\Column(type: Types::TEXT, name: 'instruction_b_to_a')]
    private ?string $instructionBtoA = null;

    #[ORM\Column(length: 255, name: 'image_a_to_b')]
    private ?string $imageAtoB = null;

    #[ORM\Column(length: 255, name: 'image_b_to_a')]
    private ?string $imageBtoA = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocationA(): ?Location
    {
        return $this->locationA;
    }

    public function setLocationA(?Location $locationA): static
    {
        $this->locationA = $locationA;

        return $this;
    }

    public function getLocationB(): ?Location
    {
        return $this->locationB;
    }

    public function setLocationB(?Location $locationB): static
    {
        $this->locationB = $locationB;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function isPmr(): ?bool
    {
        return $this->pmr;
    }

    public function setPmr(bool $pmr): static
    {
        $this->pmr = $pmr;

        return $this;
    }

    public function getInstructionAtoB(): ?string
    {
        return $this->instructionAtoB;
    }

    public function setInstructionAtoB(string $instructionAtoB): static
    {
        $this->instructionAtoB = $instructionAtoB;

        return $this;
    }

    public function getInstructionBtoA(): ?string
    {
        return $this->instructionBtoA;
    }

    public function setInstructionBtoA(string $instructionBtoA): static
    {
        $this->instructionBtoA = $instructionBtoA;

        return $this;
    }

    public function getImageAtoB(): ?string
    {
        return $this->imageAtoB;
    }

    public function setImageAtoB(?string $imageAtoB): static
    {
        $this->imageAtoB = $imageAtoB;

        return $this;
    }

    public function getImageBtoA(): ?string
    {
        return $this->imageBtoA;
    }

    public function setImageBtoA(string $imageBtoA): static
    {
        $this->imageBtoA = $imageBtoA;

        return $this;
    }
}
