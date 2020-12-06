<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\BriefRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "getBriefs" = {
 *              "path" = "/formateurs/briefs",
 *              "method" = "GET",
 *              "normalization_context" = {"groups"={"briefs:read"}}
 *          },
 *          "getBriefsFormateur" = {
 *              "path" = "/formateurs/promos/{id}/briefs",
 *              "requirements" = {"id"="\d+"},
 *              "method" = "GET",
 *              "normalization_context" = {"groups":"getBriefs:read"}
 *          },
 *          "getBriefsInGroupe" = {
 *              "path" = "/formateurs/promos/{idPromo}/groupes/{idGroup}/briefs",
 *              "requirements" = {"idPromo"="\d+","idGroup"="\d+"},
 *              "normalization_context" = {"groups"={"getBriefs:read","getBriefsInGroupe:read"}},
 *              "method" = "GET"
 *          },
 *          "getBriefsApprenant" = {
 *              "path" = "/apprenants/promos/{id}/briefs",
 *              "requirements" = {"id"="\d+"},
 *              "method" = "GET",
 *              "normalization_context" = {"groups"={"getBriefs:read","getBriefsInGroupe:read"}}
 *          },
 *          "getBriefValidByFormateur" = {
 *              "path" = "/formateurs/{id}/briefs/valide",
 *              "requirements" = {"id"="\d+"},
 *              "method" = "GET",
 *              "normalization_context" = {"groups":"briefBrVal:read"}
 *          },
 *          "getBriefBrouillonByFormateur" = {
 *              "path" = "/formateurs/{id}/briefs/brouillons",
 *              "requirements" = {"id"="\d+"},
 *              "method" = "GET",
 *              "normalization_context" = {"groups":"briefBrVal:read"}
 *               },
 *          "getBriefInPromo" = {
 *              "path" = "/formateurs/promos/{idPromo}/briefs/{idBrief}",
 *              "requirements" = {"idPromo"="\d+","idBrief"="\d+"},
 *              "method" = "GET"
 *              },
 *          "getLivrableRenduApprenant" = {
 *              "path" = "/apprenants/promos/{idPromo}/briefs/{idBrief}",
 *              "requirements" = {"idPromo"="\d+","idBrief"="\d+"},
 *              "normalization_context" = {"groups"={"apprenant:read"}},
 *              "method" = "GET"
 *               },
 *          "add_brief"={
 *              "method"="POST",
 *              "path"="/formateurs/briefs",
 *              "security"="is_granted('ROLE_FORMATEUR')",
 *              "security_message"="Vous n'avez pas access à cette Ressource",
 *          },
 *          "duplicate_brief"={
 *              "method"="POST",
 *              "path"="/formateurs/briefs/{id}"
 *          },
 *          "add_url_livrables_attendus"={
 *              "method"="POST",
 *              "path"="/apprenants/{idStudent}/groupe/{idGroupe}/livrables"
 *
 *          },
 *     }
 * )
 * @ORM\Entity(repositoryClass=BriefRepository::class)
 */
class Brief
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $langue;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $contexte;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $modalite_pedagogique;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $critere_de_performance;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $modalitesEvaluation;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $avatar;

    /**
     * @ORM\Column(type="date")
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $dateCreation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $statusBrief;

    /**
     * @ORM\ManyToOne(targetEntity=Referentiel::class, inversedBy="briefs", cascade={"persist"})
     * @Groups({"group:read"})
     */
    private $referentiel;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="briefs", cascade={"persist"})
     */
    private $tag;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archive = 0;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"briefs:read", "briefBrVal:read"})
     */
    private $etat;

    /**
     * @ORM\ManyToOne(targetEntity=Formateur::class, inversedBy="briefs", cascade={"persist"})
     * @Groups({"briefs:read"})
     */
    private $formateur;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="brief")
     */
    private $groupes;

    /**
     * @ORM\OneToMany(targetEntity=PromoBrief::class, mappedBy="brief")
     */
    private $promoBriefs;

    public function __construct()
    {
        $this->tag = new ArrayCollection();
        $this->groupes = new ArrayCollection();
        $this->promo = new ArrayCollection();
        $this->promoBriefs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getContexte(): ?string
    {
        return $this->contexte;
    }

    public function setContexte(string $contexte): self
    {
        $this->contexte = $contexte;

        return $this;
    }

    public function getModalitePedagogique(): ?string
    {
        return $this->modalite_pedagogique;
    }

    public function setModalitePedagogique(string $modalite_pedagogique): self
    {
        $this->modalite_pedagogique = $modalite_pedagogique;

        return $this;
    }

    public function getCritereDePerformance(): ?string
    {
        return $this->critere_de_performance;
    }

    public function setCritereDePerformance(string $critere_de_performance): self
    {
        $this->critere_de_performance = $critere_de_performance;

        return $this;
    }

    public function getModalitesEvaluation(): ?string
    {
        return $this->modalitesEvaluation;
    }

    public function setModalitesEvaluation(string $modalitesEvaluation): self
    {
        $this->modalitesEvaluation = $modalitesEvaluation;

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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    public function getStatusBrief(): ?string
    {
        return $this->statusBrief;
    }

    public function setStatusBrief(string $statusBrief): self
    {
        $this->statusBrief = $statusBrief;

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
     * @return Collection|Tag[]
     */
    public function getTag(): Collection
    {
        return $this->tag;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tag->contains($tag)) {
            $this->tag[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tag->removeElement($tag);

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

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }

    public function getFormateur(): ?Formateur
    {
        return $this->formateur;
    }

    public function setFormateur(?Formateur $formateur): self
    {
        $this->formateur = $formateur;

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
            $groupe->addBrief($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeBrief($this);
        }

        return $this;
    }

    /**
     * @return Collection|PromoBrief[]
     */
    public function getPromo(): Collection
    {
        return $this->promo;
    }

    public function addPromo(PromoBrief $promo): self
    {
        if (!$this->promo->contains($promo)) {
            $this->promo[] = $promo;
            $promo->setBrief($this);
        }

        return $this;
    }

    public function removePromo(PromoBrief $promo): self
    {
        if ($this->promo->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getBrief() === $this) {
                $promo->setBrief(null);
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
            $promoBrief->setBrief($this);
        }

        return $this;
    }

    public function removePromoBrief(PromoBrief $promoBrief): self
    {
        if ($this->promoBriefs->removeElement($promoBrief)) {
            // set the owning side to null (unless already changed)
            if ($promoBrief->getBrief() === $this) {
                $promoBrief->setBrief(null);
            }
        }

        return $this;
    }
}
