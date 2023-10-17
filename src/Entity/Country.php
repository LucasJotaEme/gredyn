<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 */
class Country
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
    private $name;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $prefix;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $flag;

    /**
     * @ORM\OneToMany(targetEntity=State::class, mappedBy="country")
     */
    private $states;

    /**
     * @ORM\OneToOne(targetEntity=Cordinate::class, mappedBy="country", cascade={"persist", "remove"})
     */
    private $cordinate;

    public function __construct()
    {
        $this->states = new ArrayCollection();
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

    public function getPrefix(): ?string
    {
        return $this->prefix;
    }

    public function setPrefix(?string $prefix): self
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function getFlag(): ?string
    {
        return $this->flag;
    }

    public function setFlag(?string $flag): self
    {
        $this->flag = $flag;

        return $this;
    }

    /**
     * @return Collection|State[]
     */
    public function getStates(): Collection
    {
        return $this->states;
    }

    public function addState(State $state): self
    {
        if (!$this->states->contains($state)) {
            $this->states[] = $state;
            $state->setCountry($this);
        }

        return $this;
    }

    public function removeState(State $state): self
    {
        if ($this->states->removeElement($state)) {
            // set the owning side to null (unless already changed)
            if ($state->getCountry() === $this) {
                $state->setCountry(null);
            }
        }

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
            $this->cordinate->setCountry(null);
        }

        // set the owning side of the relation if necessary
        if ($cordinate !== null && $cordinate->getCountry() !== $this) {
            $cordinate->setCountry($this);
        }

        $this->cordinate = $cordinate;

        return $this;
    }
}
