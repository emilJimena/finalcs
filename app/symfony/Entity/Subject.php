<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Subject Entity
 * 
 * @ORM\Entity(repositoryClass="App\Repository\SubjectRepository")
 * @ORM\Table(name="subject")
 */
class Subject
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private ?int $subjectId = null;

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
     * @Assert\NotBlank(message="Unit is required")
     * @Assert\Type(type="integer", message="Unit must be a number")
     * @Assert\GreaterThan(value=0, message="Unit must be greater than 0")
     */
    private ?int $unit = null;

    public function getSubjectId(): ?int
    {
        return $this->subjectId;
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

    public function getUnit(): ?int
    {
        return $this->unit;
    }

    public function setUnit(int $unit): self
    {
        $this->unit = $unit;
        return $this;
    }
}
