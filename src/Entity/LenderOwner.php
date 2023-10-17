<?php

namespace App\Entity;

use App\Repository\LenderOwnerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LenderOwnerRepository::class)
 */
class LenderOwner
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Lender::class, inversedBy="lenderOwners")
     */
    private $lender;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLender(): ?Lender
    {
        return $this->lender;
    }

    public function setLender(?Lender $lender): self
    {
        $this->lender = $lender;

        return $this;
    }
}
