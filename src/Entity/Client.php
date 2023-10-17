<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ClientRepository::class)
 */
class Client
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="client", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity=ClientAndLender::class, mappedBy="client", cascade={"persist", "remove"})
     */
    private $clientAndLender;

    public function getId(): ?int
    {
        return $this->id;
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
            $this->clientAndLender->setClient(null);
        }

        // set the owning side of the relation if necessary
        if ($clientAndLender !== null && $clientAndLender->getClient() !== $this) {
            $clientAndLender->setClient($this);
        }

        $this->clientAndLender = $clientAndLender;

        return $this;
    }
}
