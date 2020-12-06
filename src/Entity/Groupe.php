<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     denormalizationContext={"groups"="group:write"},
 *     routePrefix="admin/",
 *     collectionOperations={
 *     "getGroupe"= {
 *        "method" = "GET",
 *        "path" = "/groupes",
 *     "normalization_context"={"groups"="group:read"},
 *        "security"="is_granted('GROUPE_VIEW_ALL', object)",
 *        "security_message"="Vous n'avez pas accès"
 *     },
 *     "getApprenant"= {
 *        "method" = "GET",
 *        "path" = "/groupes/apprenants",
 *        "normalization_context"={"groups"="apprenant:read"}
 *     },
 *     "addApprenant"= {
 *        "method" = "POST",
 *        "path" = "/groupes"
 *     }
 *     },
 *     itemOperations={
 *     "getGroupeByID"= {
 *        "method" = "GET",
 *        "path" = "/groupes/{id}",
 *        "requirements" = {"id"="\d+"},
 *     },
 *     "setGroupe"= {
 *        "method" = "PUT",
 *        "path" = "/groupes/{id}",
 *        "requirements" = {"id"="\d+"},
 *     },
 *     "ArchiveApprenantInGroupe"= {
 *        "method" = "DELETE",
 *        "path" = "/groupes/{id}/apprenants/{id_}",
 *        "requirements" = {"id"="\d+", "id_"="\d+"},
 *     },
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeRepository::class)
 */
class Groupe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read", "group:write"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Groups({"group:read", "group:write"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read", "group:write"})
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"group:read", "group:write"})
     */
    private $type;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"group:read"})
     */
    private $archive = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Apprenant::class, inversedBy="groupes", cascade={"persist"})
     * @Groups({"group:read", "apprenant:read", "group:write"})
     */
    private $apprenant;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="groupes", cascade={"persist"})
     * @Groups({"group:read", "group:write"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Brief::class, inversedBy="groupes", cascade={"persist"})
     */
    private $brief;

    /**
     * @ORM\ManyToOne(targetEntity=Promo::class, inversedBy="groupes", cascade={"persist"})
     * @Groups({"group:read"})
     */
    private $promo;

    public function __construct()
    {
        $this->apprenant = new ArrayCollection();
        $this->formateur = new ArrayCollection();
        $this->brief = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getArchive(): ?bool
    {
        return $this->archive;
    }

    public function setArchive(?bool $archive): self
    {
        $this->archive = $archive;

        return $this;
    }

    /**
     * @return Collection|Apprenant[]
     */
    public function getApprenant(): Collection
    {
        return $this->apprenant;
    }

    public function addApprenant(Apprenant $apprenant): self
    {
        if (!$this->apprenant->contains($apprenant)) {
            $this->apprenant[] = $apprenant;
        }

        return $this;
    }

    public function removeApprenant(Apprenant $apprenant): self
    {
        $this->apprenant->removeElement($apprenant);

        return $this;
    }

    /**
     * @return Collection|Formateur[]
     */
    public function getFormateur(): Collection
    {
        return $this->formateur;
    }

    public function addFormateur(Formateur $formateur): self
    {
        if (!$this->formateur->contains($formateur)) {
            $this->formateur[] = $formateur;
        }

        return $this;
    }

    public function removeFormateur(Formateur $formateur): self
    {
        $this->formateur->removeElement($formateur);

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBrief(): Collection
    {
        return $this->brief;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->brief->contains($brief)) {
            $this->brief[] = $brief;
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        $this->brief->removeElement($brief);

        return $this;
    }

    public function getPromo(): ?Promo
    {
        return $this->promo;
    }

    public function setPromo(?Promo $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
}
