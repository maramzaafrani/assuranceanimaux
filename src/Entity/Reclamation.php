<?php

namespace App\Entity;

use App\Repository\ReclamationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReclamationRepository::class)]
class Reclamation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $IdBilan = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $IdClient = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $Text = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"Ce champs doit etre rempli")]
    private ?string $Etat = 'non etudié';

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdBilan(): ?string
    {
        return $this->IdBilan;
    }

    public function setIdBilan(string $IdBilan): self
    {
        $this->IdBilan = $IdBilan;

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

    public function getText(): ?string
    {
        return $this->Text;
    }

    public function setText(string $Text): self
    {
        $this->Text = $Text;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->Etat;
    }

    public function setEtat(string $Etat): self
    {
        $this->Etat = $Etat;

        return $this;
    }
}
