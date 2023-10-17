<?php

namespace App\Entity;

use App\Repository\EloRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EloRepository::class)
 */
class Elo
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
    private $measurer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $positive;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $negative;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $eloStatus;

    /**
     * @ORM\OneToOne(targetEntity=ClientAndLender::class, mappedBy="elo", cascade={"persist", "remove"})
     */
    private $clientAndLender;

    /**
     * @ORM\ManyToOne(targetEntity=Ranking::class, inversedBy="elo")
     */
    private $ranking;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMeasurer(): ?float
    {
        return $this->measurer;
    }

    public function setMeasurer(?float $measurer): self
    {
        $this->measurer = $measurer;

        return $this;
    }

    public function getPositive(): ?int
    {
        return $this->positive;
    }

    public function setPositive(int $positive): self
    {
        $this->positive = $positive;

        return $this;
    }

    public function getNegative(): ?int
    {
        return $this->negative;
    }

    public function setNegative(?int $negative): self
    {
        $this->negative = $negative;

        return $this;
    }

    public function getEloStatus(): ?string
    {
        return $this->eloStatus;
    }

    public function setEloStatus(string $eloStatus): self
    {
        $this->eloStatus = $eloStatus;

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
            $this->clientAndLender->setElo(null);
        }

        // set the owning side of the relation if necessary
        if ($clientAndLender !== null && $clientAndLender->getElo() !== $this) {
            $clientAndLender->setElo($this);
        }

        $this->clientAndLender = $clientAndLender;

        return $this;
    }

    public function getRanking(): ?Ranking
    {
        return $this->ranking;
    }

    public function setRanking(?Ranking $ranking): self
    {
        $this->ranking = $ranking;

        return $this;
    }
}
