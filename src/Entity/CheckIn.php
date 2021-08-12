<?php

namespace App\Entity;

use App\Repository\CheckInRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validators\Constraints as AppAssert;

/**
 * @ORM\Entity(repositoryClass=CheckInRepository::class)
 */
class CheckIn
{

    public const DURATION_HOUR_LIMIT_PER_WEEK = 35;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="checkIns")
     * @ORM\JoinColumn(nullable=false)
     * @AppAssert\OneUserCheckInPerDay
     * @Assert\NotBlank(message="Vous devez sélectionner un utilisateur.")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=ConstructionSite::class, inversedBy="checkIns")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotBlank(message="Vous devez sélectionner un chantier.")
     */
    private $constructionSite;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date du pointage ne peut pas être vide.")
     */
    private $dateOfCheckIn;

    /**
     * @ORM\Column(type="integer")
     * @AppAssert\DurationOfUserMaxPerWeek
     * @Assert\NotBlank(message="La durée du pointage ne peut pas être vide.")
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     htmlPattern = "[0-9]+",
     *     message="La durée n'est pas valide."
     * )
     */
    private $duration;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

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

    public function getConstructionSite(): ?ConstructionSite
    {
        return $this->constructionSite;
    }

    public function setConstructionSite(?ConstructionSite $constructionSite): self
    {
        $this->constructionSite = $constructionSite;

        return $this;
    }

    public function getDateOfCheckIn(): ?\DateTimeInterface
    {
        return $this->dateOfCheckIn;
    }

    public function setDateOfCheckIn(\DateTimeInterface $dateOfCheckIn): self
    {
        $this->dateOfCheckIn = $dateOfCheckIn;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;

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
}
