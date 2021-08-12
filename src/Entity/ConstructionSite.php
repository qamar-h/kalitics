<?php

namespace App\Entity;

use App\Repository\ConstructionSiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ConstructionSiteRepository::class)
 */
class ConstructionSite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le nom du chantier ne peut pas être vide.")
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse du chantier ne peut pas être vide.")
     */
    private $address;

    /**
     * @ORM\Column(type="integer", length=6)
     * @Assert\NotBlank(message="Le code postal du chantier ne peut pas être vide.")
     * @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     htmlPattern = "[0-9]+",
     *     message="Le code postal doit être valide."
     * )
     * @Assert\Length(
     *      min=5,
     *      max=5,
     *      minMessage="Le code postal doit contenir minimum {{ limit }} chiffres",
     *      maxMessage="Le code postal doit contenir maximum {{ limit }} chiffres",
     *      allowEmptyString = false
     * )
     */
    private $postalCode;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le ville du chantier ne peut pas être vide.")
     */
    private $city;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\NotBlank(message="La date de démarrage du chantier ne peut pas être vide.")
     */
    private $startDate;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=CheckIn::class, mappedBy="constructionSite")
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): self
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStartDate(): ?\DateTime
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTime $startDate): self
    {
        $this->startDate = $startDate;

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
            $checkIn->setConstructionSite($this);
        }

        return $this;
    }

    public function removeCheckIn(CheckIn $checkIn): self
    {
        if ($this->checkIns->removeElement($checkIn)) {
            // set the owning side to null (unless already changed)
            if ($checkIn->getConstructionSite() === $this) {
                $checkIn->setConstructionSite(null);
            }
        }

        return $this;
    }

}
