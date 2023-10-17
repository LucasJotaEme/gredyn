<?php

namespace App\Entity;

use App\Repository\ResidenceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResidenceRepository::class)
 */
class Residence
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $floor;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $apartmentNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $betweenStreetOne;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $betweenStreetTwo;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="residences")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=City::class, inversedBy="residences")
     */
    private $city;

    /**
     * @ORM\OneToOne(targetEntity=Cordinate::class, mappedBy="residence", cascade={"persist", "remove"})
     */
    private $cordinate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getFloor(): ?string
    {
        return $this->floor;
    }

    public function setFloor(?string $floor): self
    {
        $this->floor = $floor;

        return $this;
    }

    public function getApartmentNumber(): ?string
    {
        return $this->apartmentNumber;
    }

    public function setApartmentNumber(?string $apartmentNumber): self
    {
        $this->apartmentNumber = $apartmentNumber;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(?string $type): self
    {
        $this->type = $type;

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

    public function getBetweenStreetOne(): ?string
    {
        return $this->betweenStreetOne;
    }

    public function setBetweenStreetOne(?string $betweenStreetOne): self
    {
        $this->betweenStreetOne = $betweenStreetOne;

        return $this;
    }

    public function getBetweenStreetTwo(): ?string
    {
        return $this->betweenStreetTwo;
    }

    public function setBetweenStreetTwo(?string $betweenStreetTwo): self
    {
        $this->betweenStreetTwo = $betweenStreetTwo;

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

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getCordinate(): ?Cordinate
    {
        return $this->cordinate;
    }

    public function setCordinate(?Cordinate $cordinate): self
    {
        // unset the owning side of the relation if necessary
        if ($cordinate === null && $this->cordinate !== null) {
            $this->cordinate->setResidence(null);
        }

        // set the owning side of the relation if necessary
        if ($cordinate !== null && $cordinate->getResidence() !== $this) {
            $cordinate->setResidence($this);
        }

        $this->cordinate = $cordinate;

        return $this;
    }
}
