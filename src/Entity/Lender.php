<?php

namespace App\Entity;

use App\Repository\LenderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LenderRepository::class)
 */
class Lender
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
    private $lenderStatus;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $responseTime;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="lender", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=ClientAndLender::class, mappedBy="lender", cascade={"persist", "remove"})
     */
    private $clientAndLender;

    /**
     * @ORM\OneToMany(targetEntity=LenderOwner::class, mappedBy="lender")
     */
    private $lenderOwners;

    public function __construct()
    {
        $this->lenderOwners = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLenderStatus(): ?string
    {
        return $this->lenderStatus;
    }

    public function setLenderStatus(string $lenderStatus): self
    {
        $this->lenderStatus = $lenderStatus;

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

    public function getResponseTime(): ?float
    {
        return $this->responseTime;
    }

    public function setResponseTime(?float $responseTime): self
    {
        $this->responseTime = $responseTime;

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

    public function getClientAndLender(): ?ClientAndLender
    {
        return $this->clientAndLender;
    }

    public function setClientAndLender(?ClientAndLender $clientAndLender): self
    {
        // unset the owning side of the relation if necessary
        if ($clientAndLender === null && $this->clientAndLender !== null) {
            $this->clientAndLender->setLender(null);
        }

        // set the owning side of the relation if necessary
        if ($clientAndLender !== null && $clientAndLender->getLender() !== $this) {
            $clientAndLender->setLender($this);
        }

        $this->clientAndLender = $clientAndLender;

        return $this;
    }

    /**
     * @return Collection|LenderOwner[]
     */
    public function getLenderOwners(): Collection
    {
        return $this->lenderOwners;
    }

    public function addLenderOwner(LenderOwner $lenderOwner): self
    {
        if (!$this->lenderOwners->contains($lenderOwner)) {
            $this->lenderOwners[] = $lenderOwner;
            $lenderOwner->setLender($this);
        }

        return $this;
    }

    public function removeLenderOwner(LenderOwner $lenderOwner): self
    {
        if ($this->lenderOwners->removeElement($lenderOwner)) {
            // set the owning side to null (unless already changed)
            if ($lenderOwner->getLender() === $this) {
                $lenderOwner->setLender(null);
            }
        }

        return $this;
    }
}
