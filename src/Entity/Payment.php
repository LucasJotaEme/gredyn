<?php

namespace App\Entity;

use App\Repository\PaymentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentRepository::class)
 */
class Payment
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $mount;

    /**
     * @ORM\OneToOne(targetEntity=Service::class, inversedBy="payment", cascade={"persist", "remove"})
     */
    private $service;

    /**
     * @ORM\OneToOne(targetEntity=PaymentMethod::class, mappedBy="payment", cascade={"persist", "remove"})
     */
    private $paymentMethod;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMount(): ?float
    {
        return $this->mount;
    }

    public function setMount(?float $mount): self
    {
        $this->mount = $mount;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getPaymentMethod(): ?PaymentMethod
    {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?PaymentMethod $paymentMethod): self
    {
        // unset the owning side of the relation if necessary
        if ($paymentMethod === null && $this->paymentMethod !== null) {
            $this->paymentMethod->setPayment(null);
        }

        // set the owning side of the relation if necessary
        if ($paymentMethod !== null && $paymentMethod->getPayment() !== $this) {
            $paymentMethod->setPayment($this);
        }

        $this->paymentMethod = $paymentMethod;

        return $this;
    }
}
