<?php

namespace App\Entity;

use App\Repository\PaymentMethodRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PaymentMethodRepository::class)
 */
class PaymentMethod
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
    private $methodName;

    /**
     * @ORM\OneToOne(targetEntity=Payment::class, inversedBy="paymentMethod", cascade={"persist", "remove"})
     */
    private $payment;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMethodName(): ?string
    {
        return $this->methodName;
    }

    public function setMethodName(?string $methodName): self
    {
        $this->methodName = $methodName;

        return $this;
    }

    public function getPayment(): ?Payment
    {
        return $this->payment;
    }

    public function setPayment(?Payment $payment): self
    {
        $this->payment = $payment;

        return $this;
    }
}
