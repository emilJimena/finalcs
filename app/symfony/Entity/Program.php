<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Program Entity
 * 
 * @ORM\Entity(repositoryClass="App\Repository\ProgramRepository")
 * @ORM\Table(name="program")
 */
class Program
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $programId = null;

    /**
     * @ORM\Column(type="string", length=20, unique=true)
     * @Assert\NotBlank(message="Code is required")
     * @Assert\Length(max=20, maxMessage="Code must not exceed 20 characters")
     */
    private ?string $code = null;

    /**
     * @ORM\Column(type="string", length=100)
     * @Assert\NotBlank(message="Title is required")
     * @Assert\Length(max=100, maxMessage="Title must not exceed 100 characters")
     */
    private ?string $title = null;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Years is required")
     * @Assert\Type(type="integer", message="Years must be a number")
     * @Assert\GreaterThan(value=0, message="Years must be greater than 0")
     */
    private ?int $years = null;

    public function getProgramId(): ?int
    {
        return $this->programId;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

    public function getYears(): ?int
    {
        return $this->years;
    }

    public function setYears(int $years): self
    {
        $this->years = $years;
        return $this;
    }
}
