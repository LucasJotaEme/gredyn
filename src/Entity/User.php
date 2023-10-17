<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $userName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $created;

    /**
     * @ORM\Column(type="string", length=45, nullable=true)
     */
    private $dni;

    /**
     * @ORM\Column(type="bigint", nullable=true)
     */
    private $loginCount;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $birthday;

    /**
     * @ORM\OneToOne(targetEntity=UserFile::class, inversedBy="user", cascade={"persist", "remove"})
     * 
     */
    private $userFile;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\OneToOne(targetEntity=Lender::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $lender;

    /**
     * @ORM\OneToOne(targetEntity=Client::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $client;

    /**
     * @ORM\OneToMany(targetEntity=Residence::class, mappedBy="user")
     */
    private $residences;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $remindMe;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastSession;

    /**
     * @ORM\ManyToMany(targetEntity=Rol::class, inversedBy="users")
     */
    private $rolesEntity;

    public function __construct()
    {
        $this->roles = new ArrayCollection();
        $this->residences = new ArrayCollection();
        $this->rolesEntity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->userName;
    }

    /**
     * @see UserInterface
     */
    public function getRoles()
    {
        $roles = array();
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * This method can be removed in Symfony 6.0 - is not needed for apps that do not check user passwords.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function setUserName(?string $userName): self
    {
        $this->userName = $userName;

        return $this;
    }

    public function setPassword(?string $password): self
    {
        $this->password = $password;

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

    public function getDni(): ?string
    {
        return $this->dni;
    }

    public function setDni(?string $dni): self
    {
        $this->dni = $dni;

        return $this;
    }

    public function getLoginCount(): ?string
    {
        return $this->loginCount;
    }

    public function setLoginCount(?string $loginCount): self
    {
        $this->loginCount = $loginCount;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getBirthday(): ?string
    {
        return $this->birthday;
    }

    public function setBirthday(?string $birthday): self
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getUserFile(): ?UserFile
    {
        return $this->userFile;
    }

    public function setUserFile(?UserFile $userFile): self
    {
        $this->userFile = $userFile;

        return $this;
    }

    public function getLender(): ?Lender
    {
        return $this->lender;
    }

    public function setLender(?Lender $lender): self
    {
        // unset the owning side of the relation if necessary
        if ($lender === null && $this->lender !== null) {
            $this->lender->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($lender !== null && $lender->getUser() !== $this) {
            $lender->setUser($this);
        }

        $this->lender = $lender;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        // unset the owning side of the relation if necessary
        if ($client === null && $this->client !== null) {
            $this->client->setUser(null);
        }

        // set the owning side of the relation if necessary
        if ($client !== null && $client->getUser() !== $this) {
            $client->setUser($this);
        }

        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection|Residence[]
     */
    public function getResidences(): Collection
    {
        return $this->residences;
    }

    public function addResidence(Residence $residence): self
    {
        if (!$this->residences->contains($residence)) {
            $this->residences[] = $residence;
            $residence->setUser($this);
        }

        return $this;
    }

    public function removeResidence(Residence $residence): self
    {
        if ($this->residences->removeElement($residence)) {
            // set the owning side to null (unless already changed)
            if ($residence->getUser() === $this) {
                $residence->setUser(null);
            }
        }

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function getRemindMe(): ?bool
    {
        return $this->remindMe;
    }

    public function setRemindMe(?bool $remindMe): self
    {
        $this->remindMe = $remindMe;

        return $this;
    }

    public function getLastSession(): ?\DateTimeInterface
    {
        return $this->lastSession;
    }

    public function setLastSession(?\DateTimeInterface $lastSession): self
    {
        $this->lastSession = $lastSession;

        return $this;
    }

    /**
     * @return Collection|Rol[]
     */
    public function getRolesEntity(): Collection
    {
        return $this->rolesEntity;
    }

    public function addRolesEntity(Rol $rolesEntity): self
    {
        if (!$this->rolesEntity->contains($rolesEntity)) {
            $this->rolesEntity[] = $rolesEntity;
        }

        return $this;
    }

    public function removeRolesEntity(Rol $rolesEntity): self
    {
        $this->rolesEntity->removeElement($rolesEntity);

        return $this;
    }
}
