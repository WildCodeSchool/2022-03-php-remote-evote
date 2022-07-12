<?php

namespace App\Entity;

use App\Repository\CollegeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CollegeRepository::class)]
class College
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 155, nullable: true)]
    private ?string $name;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $description;

    #[ORM\Column(type: 'float', nullable: true)]
    private ?float $votePercentage;

    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'colleges')]
    private Company $company;

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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }
}
