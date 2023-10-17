<?php

namespace App\Entity;

use App\Repository\ClientAndLenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientAndLenderRepository::class)
 */
class ClientAndLender
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, inversedBy="clientAndLender", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity=Lender::class, inversedBy="clientAndLender", cascade={"persist", "remove"})
     */
    private $lender;

    /**
     * @ORM\OneToOne(targetEntity=Elo::class, inversedBy="clientAndLender", cascade={"persist", "remove"})
     */
    private $elo;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $countServicesTotal;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, mappedBy="clientsAndLenders")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="clientAndLender")
     */
    private $services;

    /**
     * @ORM\OneToOne(targetEntity=Unranked::class, inversedBy="clientAndLender", cascade={"persist", "remove"})
     */
    private $unranked;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getLender(): ?lender
    {
        return $this->lender;
    }

    public function setLender(?lender $lender): self
    {
        $this->lender = $lender;

        return $this;
    }

    public function getElo(): ?Elo
    {
        return $this->elo;
    }

    public function setElo(?Elo $elo): self
    {
        $this->elo = $elo;

        return $this;
    }

    public function getCountServicesTotal(): ?string
    {
        return $this->countServicesTotal;
    }

    public function setCountServicesTotal(?string $countServicesTotal): self
    {
        $this->countServicesTotal = $countServicesTotal;

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addClientAndLender($this);
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        if ($this->categories->removeElement($category)) {
            $category->removeClientAndLender($this);
        }

        return $this;
    }

    /**
     * @return Collection|Service[]
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): self
    {
        if (!$this->services->contains($service)) {
            $this->services[] = $service;
            $service->setClientAndLender($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getClientAndLender() === $this) {
                $service->setClientAndLender(null);
            }
        }

        return $this;
    }

    public function getUnranked(): ?Unranked
    {
        return $this->unranked;
    }

    public function setUnranked(?Unranked $unranked): self
    {
        $this->unranked = $unranked;

        return $this;
    }
}
