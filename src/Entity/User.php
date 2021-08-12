<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom de l'utilisateur ne peut pas être vide.")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le prénom de l'utilisateur ne peut pas être vide.")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le matricule de l'utilisateur ne peut pas être vide.")
     */
    private $registrationNumber;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=CheckIn::class, mappedBy="user")
     */
    private $checkIns;

    public function __construct()
    {
        $this->checkIns = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    public function setRegistrationNumber(string $registrationNumber): self
    {
        $this->registrationNumber = $registrationNumber;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|CheckIn[]
     */
    public function getCheckIns(): Collection
    {
        return $this->checkIns;
    }

    public function addCheckIn(CheckIn $checkIn): self
    {
        if (!$this->checkIns->contains($checkIn)) {
            $this->checkIns[] = $checkIn;
            $checkIn->setUser($this);
        }

        return $this;
    }

    public function removeCheckIn(CheckIn $checkIn): self
    {
        if ($this->checkIns->removeElement($checkIn)) {
            // set the owning side to null (unless already changed)
            if ($checkIn->getUser() === $this) {
                $checkIn->setUser(null);
            }
        }

        return $this;
    }


}
