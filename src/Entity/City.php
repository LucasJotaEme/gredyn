<?php

namespace App\Entity;

use App\Repository\CityRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CityRepository::class)
 */
class City
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
    private $name;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $postCode;

    /**
     * @ORM\OneToMany(targetEntity=Residence::class, mappedBy="city")
     */
    private $residences;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="cities")
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity=Cordinate::class, mappedBy="city", cascade={"persist", "remove"})
     */
    private $cordinate;

    public function __construct()
    {
        $this->residences = new ArrayCollection();
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

    public function getPostCode(): ?string
    {
        return $this->postCode;
    }

    public function setPostCode(?string $postCode): self
    {
        $this->postCode = $postCode;

        return $this;
    }

    /**
     * @return Collection|Residence[]
     */
    public function getResidences(): Collection
    {
        return $this->residences;
    }

    public function addResidence(Residence $residence): self
    {
        if (!$this->residences->contains($residence)) {
            $this->residences[] = $residence;
            $residence->setCity($this);
        }

        return $this;
    }

    public function removeResidence(Residence $residence): self
    {
        if ($this->residences->removeElement($residence)) {
            // set the owning side to null (unless already changed)
            if ($residence->getCity() === $this) {
                $residence->setCity(null);
            }
        }

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

    public function getCordinate(): ?Cordinate
    {
        return $this->cordinate;
    }

    public function setCordinate(?Cordinate $cordinate): self
    {
        // unset the owning side of the relation if necessary
        if ($cordinate === null && $this->cordinate !== null) {
            $this->cordinate->setCity(null);
        }

        // set the owning side of the relation if necessary
        if ($cordinate !== null && $cordinate->getCity() !== $this) {
            $cordinate->setCity($this);
        }

        $this->cordinate = $cordinate;

        return $this;
    }
}
