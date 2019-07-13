<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EmployerRepository")
 */
class Employer
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *  min=4,max=10,
     * minMessage="Le matricule doit avoir au moins 4 caractères",
     * maxMessage="Le matricule ne doit dépasser 10 caractères")
     */
    private $matricule;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Assert\Length(
     *  min=4,max=50,
     * minMessage="Le nom doit avoir au moins 4 caractères",
     * maxMessage="Le nom ne doit dépasser 50 caractères")
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     */
    private $datenaiss;

    /**
     * @ORM\Column(type="bigint")
     *  @Assert\Length(
     *  min=4,max=6,
     * minMessage="Le salaire doit avoir au moins 4 caractères",
     * maxMessage="Le salaire ne doit dépasser 6 caractères")
     */
    private $salaire;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="employers")
     */
    private $service;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDatenaiss(): ?\DateTimeInterface
    {
        return $this->datenaiss;
    }

    public function setDatenaiss(\DateTimeInterface $datenaiss): self
    {
        $this->datenaiss = $datenaiss;

        return $this;
    }

    public function getSalaire(): ?int
    {
        return $this->salaire;
    }

    public function setSalaire(int $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }
}
