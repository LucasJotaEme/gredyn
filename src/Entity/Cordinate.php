<?php

namespace App\Entity;

use App\Repository\CordinateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CordinateRepository::class)
 */
class Cordinate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $latitude;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $longitude;

    /**
     * @ORM\OneToOne(targetEntity=Residence::class, inversedBy="cordinate", cascade={"persist", "remove"})
     */
    private $residence;

    /**
     * @ORM\OneToOne(targetEntity=Country::class, inversedBy="cordinate", cascade={"persist", "remove"})
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=State::class, inversedBy="cordinate", cascade={"persist", "remove"})
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity=City::class, inversedBy="cordinate", cascade={"persist", "remove"})
     */
    private $city;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLatitude(): ?string
    {
        return $this->latitude;
    }

    public function setLatitude(?string $latitude): self
    {
        $this->latitude = $latitude;

        return $this;
    }

    public function getLongitude(): ?string
    {
        return $this->longitude;
    }

    public function setLongitude(?string $longitude): self
    {
        $this->longitude = $longitude;

        return $this;
    }

    public function getResidence(): ?Residence
    {
        return $this->residence;
    }

    public function setResidence(?Residence $residence): self
    {
        $this->residence = $residence;

        return $this;
    }

    public function getCountry(): ?Country
    {
        return $this->country;
    }

    public function setCountry(?Country $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

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
}
