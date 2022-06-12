<?php

namespace App\Entity;

use App\Repository\VoterRepository;
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
}
