<?php

namespace App\Entity;

use App\Repository\UserFileRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserFileRepository::class)
 */
class UserFile
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
    private $frontDni;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $backDni;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $profilePicture;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="userFile", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFrontDni(): ?string
    {
        return $this->frontDni;
    }

    public function setFrontDni(?string $frontDni): self
    {
        $this->frontDni = $frontDni;

        return $this;
    }

    public function getBackDni(): ?string
    {
        return $this->backDni;
    }

    public function setBackDni(?string $backDni): self
    {
        $this->backDni = $backDni;

        return $this;
    }

    public function getProfilePicture(): ?string
    {
        return $this->profilePicture;
    }

    public function setProfilePicture(?string $profilePicture): self
    {
        $this->profilePicture = $profilePicture;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setUserFile(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getUserFile() !== $this) {
            $user->setUserFile($this);
        }

        $this->user = $user;

        return $this;
    }
}
