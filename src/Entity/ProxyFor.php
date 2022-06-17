<?php

namespace App\Entity;

use App\Repository\ProxyForRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProxyForRepository::class)]
class ProxyFor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 155, nullable: true)]
    private string $name;

    #[ORM\ManyToOne(targetEntity: Voter::class, inversedBy: 'proxyFor')]
    private ?Voter $voter;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

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
