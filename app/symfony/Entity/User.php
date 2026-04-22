<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * User Entity
 * 
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="users", indexes={@ORM\Index(name="idx_username", columns={"username"})})
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     * @Assert\NotBlank(message="Username is required")
     * @Assert\Length(min=3, max=50, minMessage="Username must be at least 3 characters")
     */
    private ?string $username = null;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Password is required")
     * @Assert\Length(min=6, minMessage="Password must be at least 6 characters")
     */
    private ?string $password = null;

    /**
     * @ORM\Column(type="string", length=20)
     * @Assert\Choice(choices={"admin", "staff", "teacher", "student"})
     */
    private ?string $accountType = 'student';

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $createdOn = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $createdBy = null;

    /**
     * @ORM\Column(type="datetime")
     */
    private ?DateTime $updatedOn = null;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private ?int $updatedBy = null;

    public function __construct()
    {
        $this->createdOn = new DateTime();
        $this->updatedOn = new DateTime();
        $this->accountType = 'student';
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function getAccountType(): ?string
    {
        return $this->accountType;
    }

    public function setAccountType(string $accountType): self
    {
        $this->accountType = $accountType;
        return $this;
    }

    public function getCreatedOn(): ?DateTime
    {
        return $this->createdOn;
    }

    public function setCreatedOn(DateTime $createdOn): self
    {
        $this->createdOn = $createdOn;
        return $this;
    }

    public function getCreatedBy(): ?int
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?int $createdBy): self
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    public function getUpdatedOn(): ?DateTime
    {
        return $this->updatedOn;
    }

    public function setUpdatedOn(DateTime $updatedOn): self
    {
        $this->updatedOn = $updatedOn;
        return $this;
    }

    public function getUpdatedBy(): ?int
    {
        return $this->updatedBy;
    }

    public function setUpdatedBy(?int $updatedBy): self
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }

    /**
     * UserInterface methods
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getRoles(): array
    {
        return ['ROLE_' . strtoupper($this->accountType)];
    }

    public function eraseCredentials(): void
    {
        // Nothing to do
    }

    public function isAdmin(): bool
    {
        return $this->accountType === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->accountType === 'staff';
    }

    public function isTeacher(): bool
    {
        return $this->accountType === 'teacher';
    }

    public function isStudent(): bool
    {
        return $this->accountType === 'student';
    }
}
