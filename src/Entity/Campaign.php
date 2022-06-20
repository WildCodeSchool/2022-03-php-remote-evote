<?php

namespace App\Entity;

use App\Repository\CampaignRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Datetime;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
#[UniqueEntity(
    fields: ['uuid'],
    message: 'Cet uuid existe déjà'
)]

class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner un nom de campagne')]
    private string $name;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $startedAt;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private DateTime $endedAt;

    #[ORM\Column(type: 'boolean', length: 255, nullable: true)]
    private bool $status;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $result;

    #[ORM\Column(type: 'string', nullable: true)]
    private string $uuid;

    #[ORM\Column(type: 'text', nullable: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner une description de campagne')]
    private string $description;

    #[ORM\ManyToOne(targetEntity: Company::class, cascade: ['persist'])]
    private Company $company;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private Datetime $createdAt;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private bool $hasCollege;
    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: Resolution::class)]
    private Collection $resolutions;

    #[ORM\OneToMany(mappedBy: 'campaign', targetEntity: Voter::class)]
    private Collection $voters;

    public function __construct()
    {
        $this->resolutions = new ArrayCollection();
        $this->voters = new ArrayCollection();
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

    public function getStartedAt(): ?DateTime
    {
        return $this->startedAt;
    }

    public function setStartedAt(DateTime $startedAt): self
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    public function getEndedAt(): ?DateTime
    {
        return $this->endedAt;
    }

    public function setEndedAt(DateTime $endedAt): self
    {
        $this->endedAt = $endedAt;

        return $this;
    }

    public function getStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getResult(): ?int
    {
        return $this->result;
    }

    public function setResult(int $result): self
    {
        $this->result = $result;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getHasCollege(): ?bool
    {
        return $this->hasCollege;
    }

    public function setHasCollege(?bool $hasCollege): self
    {
        $this->hasCollege = $hasCollege;

        return $this;
    }

    /**
     * @return Collection<int, Resolution>
     */
    public function getResolutions(): Collection
    {
        return $this->resolutions;
    }

    public function addResolution(Resolution $resolution): self
    {
        if (!$this->resolutions->contains($resolution)) {
            $this->resolutions[] = $resolution;
            $resolution->setCampaign($this);
        }

        return $this;
    }

    public function removeResolution(Resolution $resolution): self
    {
        if ($this->resolutions->removeElement($resolution)) {
            // set the owning side to null (unless already changed)
            if ($resolution->getCampaign() === $this) {
                $resolution->setCampaign(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, Voter>
     */

    public function getVoters(): Collection
    {
        return $this->voters;
    }

    public function addVoter(Voter $voter): self
    {
        if (!$this->voters->contains($voter)) {
            $this->voters[] = $voter;
            $voter->setCampaign(null);
        }

        return $this;
    }

    public function removeVoter(Voter $voter): self
    {
        if ($this->voters->removeElement($voter)) {
            // set the owning side to null (unless already changed)
            if ($voter->getCampaign() === $this) {
                $voter->setCampaign(null);
            }
        }
        return $this;
    }

    /**
     * Get the value of createdAt
     */
    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    /**
     * Set the value of createdAt
     *
     * @return  self
     */
    public function setCreatedAt(?\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }
}
