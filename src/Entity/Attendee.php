<?php

namespace App\Entity;

use App\Repository\AttendeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AttendeeRepository::class)]
class Attendee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $city = null;

    #[ORM\Column(length: 255)]
    private ?string $state = null;

    #[ORM\Column(length: 255)]
    private ?string $country = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_on = null;

    #[ORM\Column]
    private ?int $created_by = null;

    #[ORM\Column(nullable: true)]
    private ?bool $is_deleted = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $deleted_on = null;

    #[ORM\Column(nullable: true)]
    private ?int $deleted_by = null;

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

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(?string $state): static
    {
        $this->state = $state;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): static
    {
        $this->country = $country;

        return $this;
    }

    public function getCreatedOn(): ?\DateTimeInterface
    {
        return $this->created_on;
    }

    public function setCreatedOn(\DateTimeInterface $created_on): static
    {
        $this->created_on = $created_on;

        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->created_by;
    }

    public function setCreatedBy(int $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function isDeleted(): ?bool
    {
        return $this->is_deleted;
    }

    public function setIsDeleted(?bool $is_deleted): static
    {
        $this->is_deleted = $is_deleted;

        return $this;
    }

    public function getDeletedOn(): ?\DateTimeInterface
    {
        return $this->deleted_on;
    }

    public function setDeletedOn(?\DateTimeInterface $deleted_on): static
    {
        $this->deleted_on = $deleted_on;

        return $this;
    }

    public function getDeletedBy(): ?int
    {
        return $this->deleted_by;
    }

    public function setDeletedBy(?int $deleted_by): static
    {
        $this->deleted_by = $deleted_by;

        return $this;
    }
}
