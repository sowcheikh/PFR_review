<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get_promos" = {
 *              "method"="GET",
 *              "path"="/admin/promos",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('VIEW_ALL', object)",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *           },
 *          "get_principal" = {
 *              "method"="GET",
 *              "path"="/admin/promos/principal",
 *              "normalization_context"={"groups"={"promos:read","promos:appreant:read"}},
 *              "security"="is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *           },
 *          "get_attente" = {
 *              "method"="GET",
 *              "path"="/admin/promos/apprenants/attente",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *           },
 *          "add_promo" = {
 *              "method"="POST",
 *              "path"="/admin/promos",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *           }
 *     },
 *     itemOperations={
 *
 *          "get_promo" = {
 *              "method"="GET",
 *              "path"="/admin/promos/{id}",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('VIEW',object)",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *           },
 *          "get_principal" = {
 *              "method"="GET",
 *              "path"="/admin/promos/{id}/principal",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('VIEW',object)",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *           },
 *          "set_promo" = {
 *              "method" = "PUT",
 *              "path" = "admin/promos/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('SET',object)",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *          },
 *          "setFormateur" = {
 *              "method" = "PUT",
 *              "path" = "/admin/promos/{id}/formateurs",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('SET',object)",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *          },
 *          "setStatutGroupe" = {
 *              "method" = "PUT",
 *              "path" = "/admin/promos/{idPromo}/groupes/{idGroupe}",
 *              "normalization_context"={"groups"={"promos:read"}},
 *              "security"="is_granted('SET',object)",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *          }
 *     },
 * )
 * @ORM\Entity(repositoryClass=PromoRepository::class)
 */
class Promo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promos:read"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"promos:read"})
     */
    private $lieu;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promos:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promos:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"promos:read"})
     */
    private $fabrique;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"promos:read"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"promos:read"})
     */
    private $archive = 0;

    /**
     * @ORM\Column(type="date")
     * @Groups({"promos:read"})
     */
    private $dateDebut;

    /**
     * @ORM\Column(type="date")
     * @Groups({"promos:read"})
     */
    private $dateFin;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="promos", cascade={"persist"})
     * @Groups({"promos:read", "group:read"})
     */
    private $referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=Formateur::class, inversedBy="promos")
     * @Groups({"promos:read"})
     */
    private $formateur;

    /**
     * @ORM\OneToMany(targetEntity=Groupe::class, mappedBy="promo")
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=PromoBrief::class, mappedBy="promo")
     */
    private $promoBriefs;

    public function __construct()
    {
        $this->formateur = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->promoBriefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getFabrique(): ?string
    {
        return $this->fabrique;
    }

    public function setFabrique(string $fabrique): self
    {
        $this->fabrique = $fabrique;

        return $this;
    }

    public function getAvatar()
    {
        $avatar = @stream_get_contents($this->avatar);
        @fclose($this->avatar);
        return base64_encode($avatar);
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

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

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $dateDebut): self
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $dateFin): self
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    public function getReferentiel(): ?Referentiel
    {
        return $this->referentiel;
    }

    public function setReferentiel(?Referentiel $referentiel): self
    {
        $this->referentiel = $referentiel;

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
     * @return Collection|Groupe[]
     */
    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Groupe $groupe): self
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes[] = $groupe;
            $groupe->setPromo($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            // set the owning side to null (unless already changed)
            if ($groupe->getPromo() === $this) {
                $groupe->setPromo(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PromoBrief[]
     */
    public function getPromoBriefs(): Collection
    {
        return $this->promoBriefs;
    }

    public function addPromoBrief(PromoBrief $promoBrief): self
    {
        if (!$this->promoBriefs->contains($promoBrief)) {
            $this->promoBriefs[] = $promoBrief;
            $promoBrief->setPromo($this);
        }

        return $this;
    }

    public function removePromoBrief(PromoBrief $promoBrief): self
    {
        if ($this->promoBriefs->removeElement($promoBrief)) {
            // set the owning side to null (unless already changed)
            if ($promoBrief->getPromo() === $this) {
                $promoBrief->setPromo(null);
            }
        }

        return $this;
    }
}
