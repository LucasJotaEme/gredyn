<?php

namespace App\Entity;

use App\Repository\RankingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RankingRepository::class)
 */
class Ranking
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
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $numberFrom;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $numberTo;

    /**
     * @ORM\OneToMany(targetEntity=Elo::class, mappedBy="ranking")
     */
    private $elos;

    public function __construct()
    {
        $this->elos = new ArrayCollection();
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

    public function getNumberFrom(): ?float
    {
        return $this->numberFrom;
    }

    public function setNumberFrom(?float $numberFrom): self
    {
        $this->numberFrom = $numberFrom;

        return $this;
    }

    public function getNumberTo(): ?float
    {
        return $this->numberTo;
    }

    public function setNumberTo(?float $numberTo): self
    {
        $this->numberTo = $numberTo;

        return $this;
    }

    /**
     * @return Collection|Elo[]
     */
    public function getElos(): Collection
    {
        return $this->elos;
    }

    public function addElo(Elo $elo): self
    {
        if (!$this->elos->contains($elo)) {
            $this->elos[] = $elo;
            $elo->setRanking($this);
        }

        return $this;
    }

    public function removeElo(Elo $elo): self
    {
        if ($this->elos->removeElement($elo)) {
            // set the owning side to null (unless already changed)
            if ($elo->getRanking() === $this) {
                $elo->setRanking(null);
            }
        }

        return $this;
    }
}
