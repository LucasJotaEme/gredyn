<?php

namespace App\Entity;

use App\Repository\UnrankedRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UnrankedRepository::class)
 */
class Unranked
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
    private $starRating;

    /**
     * @ORM\OneToOne(targetEntity=ClientAndLender::class, mappedBy="unranked", cascade={"persist", "remove"})
     */
    private $clientAndLender;

    public function __construct()
    {
        $this->clientsAndLenders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStarRating(): ?string
    {
        return $this->starRating;
    }

    public function setStarRating(?string $starRating): self
    {
        $this->starRating = $starRating;

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
            $this->clientAndLender->setUnranked(null);
        }

        // set the owning side of the relation if necessary
        if ($clientAndLender !== null && $clientAndLender->getUnranked() !== $this) {
            $clientAndLender->setUnranked($this);
        }

        $this->clientAndLender = $clientAndLender;

        return $this;
    }
}
