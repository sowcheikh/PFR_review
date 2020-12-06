<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ReferentielRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *     denormalizationContext={"groups"={"referentiels:write"}},
 *     collectionOperations={
 *          "getReferentiels"={
 *              "method" = "GET",
 *              "path" = "/referentiels",
 *              "normalization_context"={"groups"={"referentiels:read"}}
 *          },
 *     "getCompAndGrpCompInReferentiels"={
 *              "method" = "GET",
 *              "path" = "/referentiels/grpecompetences",
 *              "normalization_context"={"groups"={"referentiels:read", "ref_grpComp:read"}}
 *          },
 *          "addReferentiels"={
 *              "method" = "POST",
 *              "path" = "/referentiels",
 *              "normalization_context"={"groups"={"referentiels:read"}}
 *          },
 *     },
 *     itemOperations={
 *          "getReferentielsByID"={
 *              "method" = "GET",
 *              "path" = "/referentiels/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"referentiels:read"}}
 *          },
 *     "getCompInGrpInRefs"={
 *              "method" = "GET",
 *              "path" = "/referentiels/{id_1}/grpcompetences/{id_2}",
 *              "requirements"={"id_1"="\d+", "id_2"="\d+"},
 *          },
 *          "setReferentiels"={
 *              "method" = "PUT",
 *              "path" = "/referentiels/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"referentiels:write"}},
 *              "input_formats"={"json"={"application/ld+json", "application/json" }},
 *              "output_formats"={"json"={"application/ld+json", "application/json"}}
 *          },
 *     }
 * )
 * @ORM\Entity(repositoryClass=ReferentielRepository::class)
 */
class Referentiel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read"})
     * @Assert\NotBlank()
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read"})
     * @Assert\NotBlank()
     */
    private $presentation;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $critereAdmission;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $critereEvaluation;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $archive = 0;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, inversedBy="referentiels", cascade={"persist"})
     * @Groups({"referentiels:read", "referentiels:write", "ref_grpComp:read", "ref_c_grp:read"})
     */
    private $groupeCompetence;

    /**
     * @ORM\OneToMany(targetEntity=Brief::class, mappedBy="referentiel", cascade={"persist"})
     */
    private $briefs;

    /**
     * @ORM\OneToMany(targetEntity=Promo::class, mappedBy="referentiel", cascade={"persist"})
     */
    private $promos;

    public function __construct()
    {
        $this->groupeCompetence = new ArrayCollection();
        $this->briefs = new ArrayCollection();
        $this->promos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(string $presentation): self
    {
        $this->presentation = $presentation;

        return $this;
    }

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getCritereAdmission(): ?string
    {
        return $this->critereAdmission;
    }

    public function setCritereAdmission(string $critereAdmission): self
    {
        $this->critereAdmission = $critereAdmission;

        return $this;
    }

    public function getCritereEvaluation(): ?string
    {
        return $this->critereEvaluation;
    }

    public function setCritereEvaluation(string $critereEvaluation): self
    {
        $this->critereEvaluation = $critereEvaluation;

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
     * @return Collection|GroupeCompetences[]
     */
    public function getGroupeCompetence(): Collection
    {
        return $this->groupeCompetence;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetence->contains($groupeCompetence)) {
            $this->groupeCompetence[] = $groupeCompetence;
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        $this->groupeCompetence->removeElement($groupeCompetence);

        return $this;
    }

    /**
     * @return Collection|Brief[]
     */
    public function getBriefs(): Collection
    {
        return $this->briefs;
    }

    public function addBrief(Brief $brief): self
    {
        if (!$this->briefs->contains($brief)) {
            $this->briefs[] = $brief;
            $brief->setReferentiel($this);
        }

        return $this;
    }

    public function removeBrief(Brief $brief): self
    {
        if ($this->briefs->removeElement($brief)) {
            // set the owning side to null (unless already changed)
            if ($brief->getReferentiel() === $this) {
                $brief->setReferentiel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Promo[]
     */
    public function getPromos(): Collection
    {
        return $this->promos;
    }

    public function addPromo(Promo $promo): self
    {
        if (!$this->promos->contains($promo)) {
            $this->promos[] = $promo;
            $promo->setReferentiel($this);
        }

        return $this;
    }

    public function removePromo(Promo $promo): self
    {
        if ($this->promos->removeElement($promo)) {
            // set the owning side to null (unless already changed)
            if ($promo->getReferentiel() === $this) {
                $promo->setReferentiel(null);
            }
        }

        return $this;
    }
}
