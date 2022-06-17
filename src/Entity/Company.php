<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $name;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: College::class)]
    private Collection $colleges;

    public function __construct()
    {
        $this->colleges = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, College>
     */
    public function getColleges(): Collection
    {
        return $this->colleges;
    }

    public function addCollege(College $college): self
    {
        if (!$this->colleges->contains($college)) {
            $this->colleges[] = $college;
            $college->setCompany($this);
        }

        return $this;
    }

    public function removeCollege(College $college): self
    {
        if ($this->colleges->removeElement($college)) {
            // set the owning side to null (unless already changed)
            if ($college->getCompany() === $this) {
                $college->setCompany(null);
            }
        }

        return $this;
    }
}
