<?php

namespace App\Entity;

use App\Repository\BilanDeSoinRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: BilanDeSoinRepository::class)]
class BilanDeSoin
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $IdClient = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $IdVeterinaire = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $Animal = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $Description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    #[Assert\Positive(message:"Prix doit etre un nombre positif")]
    private ?float $Prix = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $etat = 'non etudié';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBilan(): ?string
    {
        return $this->Id_Bilan;
    }

    public function setIdBilan(string $Id_Bilan): self
    {
        $this->Id_Bilan = $Id_Bilan;

        return $this;
    }

    public function getIdClient(): ?string
    {
        return $this->IdClient;
    }

    public function setIdClient(string $IdClient): self
    {
        $this->IdClient = $IdClient;

        return $this;
    }

    public function getIdVeterinaire(): ?string
    {
        return $this->IdVeterinaire;
    }

    public function setIdVeterinaire(string $IdVeterinaire): self
    {
        $this->IdVeterinaire = $IdVeterinaire;

        return $this;
    }

    public function getAnimal(): ?string
    {
        return $this->Animal;
    }

    public function setAnimal(string $Animal): self
    {
        $this->Animal = $Animal;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
