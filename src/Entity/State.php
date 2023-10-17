<?php

namespace App\Entity;

use App\Repository\StateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StateRepository::class)
 */
class State
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=City::class, mappedBy="state")
     */
    private $cities;

    /**
     * @ORM\ManyToOne(targetEntity=Country::class, inversedBy="states")
     */
    private $country;

    /**
     * @ORM\OneToOne(targetEntity=Cordinate::class, mappedBy="state", cascade={"persist", "remove"})
     */
    private $cordinate;

    public function __construct()
    {
        $this->cities = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|City[]
     */
    public function getCities(): Collection
    {
        return $this->cities;
    }

    public function addCity(City $city): self
    {
        if (!$this->cities->contains($city)) {
            $this->cities[] = $city;
            $city->setState($this);
        }

        return $this;
    }

    public function removeCity(City $city): self
    {
        if ($this->cities->removeElement($city)) {
            // set the owning side to null (unless already changed)
            if ($city->getState() === $this) {
                $city->setState(null);
            }
        }

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

    public function getCordinate(): ?Cordinate
    {
        return $this->cordinate;
    }

    public function setCordinate(?Cordinate $cordinate): self
    {
        // unset the owning side of the relation if necessary
        if ($cordinate === null && $this->cordinate !== null) {
            $this->cordinate->setState(null);
        }

        // set the owning side of the relation if necessary
        if ($cordinate !== null && $cordinate->getState() !== $this) {
            $cordinate->setState($this);
        }

        $this->cordinate = $cordinate;

        return $this;
    }
}
