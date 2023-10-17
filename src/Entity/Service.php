<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=ClientAndLender::class, inversedBy="services")
     */
    private $clientAndLender;

    /**
     * @ORM\OneToOne(targetEntity=Qualification::class, mappedBy="service", cascade={"persist", "remove"})
     */
    private $qualification;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, mappedBy="service", cascade={"persist", "remove"})
     */
    private $payment;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="services")
     */
    private $category;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getClientAndLender(): ?ClientAndLender
    {
        return $this->clientAndLender;
    }

    public function setClientAndLender(?ClientAndLender $clientAndLender): self
    {
        $this->clientAndLender = $clientAndLender;

        return $this;
    }

    public function getQualification(): ?Qualification
    {
        return $this->qualification;
    }

    public function setQualification(?Qualification $qualification): self
    {
        // unset the owning side of the relation if necessary
        if ($qualification === null && $this->qualification !== null) {
            $this->qualification->setService(null);
        }

        // set the owning side of the relation if necessary
        if ($qualification !== null && $qualification->getService() !== $this) {
            $qualification->setService($this);
        }

        $this->qualification = $qualification;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        // unset the owning side of the relation if necessary
        if ($payment === null && $this->payment !== null) {
            $this->payment->setService(null);
        }

        // set the owning side of the relation if necessary
        if ($payment !== null && $payment->getService() !== $this) {
            $payment->setService($this);
        }

        $this->payment = $payment;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }
}
