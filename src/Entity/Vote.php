<?php

namespace App\Entity;

use App\Repository\VoteRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VoteRepository::class)]
class Vote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 10, nullable: true)]
    private string $answer;

    #[ORM\ManyToOne(targetEntity: Resolution::class, inversedBy: 'votes')]
    private Resolution $resolution;

    #[ORM\ManyToOne(targetEntity: Voter::class, inversedBy: 'votes')]
    private Voter $voter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(?string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getResolution(): ?Resolution
    {
        return $this->resolution;
    }

    public function setResolution(?Resolution $resolution): self
    {
        $this->resolution = $resolution;

        return $this;
    }

    public function getVoter(): ?Voter
    {
        return $this->voter;
    }

    public function setVoter(?Voter $voter): self
    {
        $this->voter = $voter;

        return $this;
    }
}
