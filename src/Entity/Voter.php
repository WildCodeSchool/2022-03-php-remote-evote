<?php

namespace App\Entity;

use App\Repository\VoterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: VoterRepository::class)]
#[UniqueEntity(
    fields: ['uuid'],
    message: 'Cet uuid existe déjà'
)]

class Voter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 155, nullable: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner le nom du participant')]
    private string $fullname;

    #[ORM\Column(type: 'string', length: 155, nullable: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner l\'email du participant')]
    private string $email;

    #[ORM\Column(type: 'integer', nullable: true)]
    #[Assert\NotBlank(message: 'Merci de renseigner le téléphone du participant')]
    private int $telephone;

    #[ORM\Column(type: 'string', nullable: true)]
    private string $uuid;

    #[ORM\ManyToOne(targetEntity: Company::class, cascade: ['persist'])]
    private Company $company;

    #[ORM\ManyToOne(targetEntity: College::class)]
    private College $college;

    #[ORM\Column(type: 'float', nullable: true)]
    private float $votePercentage;

    #[ORM\Column(type: 'integer', nullable: true)]
    private int $numberOfVote;

    #[ORM\OneToMany(mappedBy: 'voter', targetEntity: ProxyFor::class, cascade: ['persist', 'remove'])]
    private Collection $proxyFor;

    #[ORM\ManyToOne(targetEntity: Campaign::class, inversedBy: 'voters')]
    private ?Campaign $campaign;

    #[ORM\OneToMany(mappedBy: 'voter', targetEntity: Vote::class)]
    private Collection $votes;

    public function __construct()
    {
        $this->proxyFor = new ArrayCollection();
        $this->votes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFullname(): ?string
    {
        return $this->fullname;
    }

    public function setFullname(?string $fullname): self
    {
        $this->fullname = $fullname;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(?int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    public function setUuid(?string $uuid): self
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

    public function getCollege(): ?College
    {
        return $this->college;
    }

    public function setCollege(?College $college): self
    {
        $this->college = $college;

        return $this;
    }

    public function getVotePercentage(): ?float
    {
        return $this->votePercentage;
    }

    public function setVotePercentage(?float $votePercentage): self
    {
        $this->votePercentage = $votePercentage;

        return $this;
    }

    public function getNumberOfVote(): ?int
    {
        return $this->numberOfVote;
    }

    public function setNumberOfVote(?int $numberOfVote): self
    {
        $this->numberOfVote = $numberOfVote;

        return $this;
    }

    /**
     * @return Collection<int, ProxyFor>
     */
    public function getProxyFor(): Collection
    {
        return $this->proxyFor;
    }

    public function addProxyFor(ProxyFor $proxyFor): self
    {
        if (!$this->proxyFor->contains($proxyFor)) {
            $this->proxyFor[] = $proxyFor;
            $proxyFor->setVoter($this);
        }

        return $this;
    }

    public function removeProxyFor(ProxyFor $proxyFor): self
    {
        if ($this->proxyFor->removeElement($proxyFor)) {
            // set the owning side to null (unless already changed)
            if ($proxyFor->getVoter() === $this) {
                $proxyFor->setVoter(null);
            }
        }

        return $this;
    }

    public function getCampaign(): ?Campaign
    {
        return $this->campaign;
    }

    public function setCampaign(?Campaign $campaign): self
    {
        $this->campaign = $campaign;

        return $this;
    }

    /**
     * @return Collection<int, Vote>
     */
    public function getVotes(): Collection
    {
        return $this->votes;
    }

    public function addVote(Vote $vote): self
    {
        if (!$this->votes->contains($vote)) {
            $this->votes[] = $vote;
            $vote->setVoter($this);
        }

        return $this;
    }

    public function removeVote(Vote $vote): self
    {
        if ($this->votes->removeElement($vote)) {
            // set the owning side to null (unless already changed)
            if ($vote->getVoter() === $this) {
                $vote->setVoter(null);
            }
        }

        return $this;
    }
}
