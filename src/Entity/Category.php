<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategoryRepository::class)
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $starRating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photo;

    /**
     * @ORM\ManyToMany(targetEntity=ClientAndLender::class, inversedBy="categories")
     */
    private $clientsAndLenders;

    /**
     * @ORM\OneToMany(targetEntity=CategoryType::class, mappedBy="category")
     */
    private $categoryTypes;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=Service::class, mappedBy="category")
     */
    private $services;

    public function __construct()
    {
        $this->clientsAndLenders = new ArrayCollection();
        $this->categoryTypes = new ArrayCollection();
        $this->services = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?float $totalPrice): self
    {
        $this->totalPrice = $totalPrice;

        return $this;
    }

    public function getStarRating(): ?float
    {
        return $this->starRating;
    }

    public function setStarRating(?float $starRating): self
    {
        $this->starRating = $starRating;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * @return Collection|ClientAndLender[]
     */
    public function getClientsAndLenders(): Collection
    {
        return $this->clientsAndLenders;
    }

    public function addClientAndLender(ClientAndLender $clientAndLender): self
    {
        if (!$this->clientsAndLenders->contains($clientAndLender)) {
            $this->clientsAndLenders[] = $clientAndLender;
        }

        return $this;
    }

    public function removeClientAndLender(ClientAndLender $clientAndLender): self
    {
        $this->clientsAndLenders->removeElement($clientAndLender);

        return $this;
    }

    /**
     * @return Collection|CategoryType[]
     */
    public function getCategoryTypes(): Collection
    {
        return $this->categoryTypes;
    }

    public function addCategoryType(CategoryType $categoryType): self
    {
        if (!$this->categoryTypes->contains($categoryType)) {
            $this->categoryTypes[] = $categoryType;
            $categoryType->setCategory($this);
        }

        return $this;
    }

    public function removeCategoryType(CategoryType $categoryType): self
    {
        if ($this->categoryTypes->removeElement($categoryType)) {
            // set the owning side to null (unless already changed)
            if ($categoryType->getCategory() === $this) {
                $categoryType->setCategory(null);
            }
        }

        return $this;
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
            $service->setCategory($this);
        }

        return $this;
    }

    public function removeService(Service $service): self
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCategory() === $this) {
                $service->setCategory(null);
            }
        }

        return $this;
    }
}
