<?php

namespace App\Entity;

use App\Repository\ContratRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Ignore;

#[ORM\Entity(repositoryClass: ContratRepository::class)]
class Contrat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter nom client")]
    private ?string $NomClient = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter prenom client")]
    private ?string $Prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter Tel client")]
    private ?string $Tel = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter adresse client")]
    private ?string $adresse = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter Email client")]
    
    /**
     * @Assert\Regex(
     *     pattern="/@/",
     *     message="L'adresse email doit contenir le caractère '@'."
     * )
     */
    private ?string $Email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter date de debut client")]
    private ?string $Datededebut = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:"il est obligatoire d'ajouter date de fin client")]
    private ?string $Datedefin = null;

    #[ORM\ManyToOne(inversedBy: 'contrats')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TypeContrat $TypeContrat = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomClient(): ?string
    {
        return $this->NomClient;
    }

    public function setNomClient(string $NomClient): self
    {
        $this->NomClient = $NomClient;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->Tel;
    }

    public function setTel(string $Tel): self
    {
        $this->Tel = $Tel;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getDatededebut(): ?string
    {
        return $this->Datededebut;
    }

    public function setDatededebut(string $Datededebut): self
    {
        $this->Datededebut = $Datededebut;

        return $this;
    }

    public function getDatedefin(): ?string
    {
        return $this->Datedefin;
    }

    public function setDatedefin(string $Datedefin): self
    {
        $this->Datedefin = $Datedefin;

        return $this;
    }

    public function getTypeContrat(): ?Typecontrat
    {
        return $this->TypeContrat;
    }

    public function setTypeContrat(?Typecontrat $TypeContrat): self
    {
        $this->TypeContrat = $TypeContrat;

        return $this;
    }
    
}
