<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeCompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get_grpeCompetences"={
 *              "method" = "GET",
 *              "path" = "/admin/grpecompetences",
 *              "normalization_context"={"groups"={"grpecompetence:read_m"}}
 *          },
 *          "get_competences"={
 *              "method" = "GET",
 *              "path" = "/admin/grpecompetences/competences",
 *              "normalization_context"={"groups"={"grpecompetence:competence:read"}}
 *          },
 *          "add_groupeCompetence"={
 *              "method" = "POST",
 *              "path" = "/admin/grpecompetences",
 *              "normalization_context"={"groups"={"grpecompetence:read_m"}}
 *          },
 *     },
 *     itemOperations={
 *          "get_groupeCompetence"={
 *              "method" = "GET",
 *              "path" = "/admin/grpecompetences/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"grpecompetence:read_m"}}
 *          },
 *          "get_competence_in_grpeCompetence"={
 *              "method" = "GET",
 *              "path" = "/admin/grpecompetences/{id}/competences",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"grpecompetence:read_m"}}
 *          },
 *          "set_grpeCompetence"={
 *              "method" = "PUT",
 *              "path" = "/admin/grpecompetences/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"grpecompetence:read_m","grpecompetence:competence:read"}}
 *     }
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeCompetencesRepository::class)
 */
class GroupeCompetences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"grpecompetence:read_m", "competence:read", "referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpecompetence:read_m", "competence:read", "referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"grpecompetence:read_m", "competence:read", "referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"grpecompetence:read_m", "competence:read", "referentiels:read", "referentiels:write", "ref_grpComp:read"})
     */
    private $archive = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Competences::class, inversedBy="groupeCompetences", cascade={"persist"})
     * @Groups({"grpecompetence:read_m", "grpecompetence:competence:read", "ref_grpComp:read", "ref_c_grp:read"})
     */
    private $competence;

    /**
     * @ORM\ManyToMany(targetEntity=Referentiel::class, mappedBy="groupeCompetence", cascade={"persist"})
     */
    private $referentiels;

    public function __construct()
    {
        $this->competence = new ArrayCollection();
        $this->referentiels = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

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
     * @return Collection|Competences[]
     */
    public function getCompetence(): Collection
    {
        return $this->competence;
    }

    public function addCompetence(Competences $competence): self
    {
        if (!$this->competence->contains($competence)) {
            $this->competence[] = $competence;
        }

        return $this;
    }

    public function removeCompetence(Competences $competence): self
    {
        $this->competence->removeElement($competence);

        return $this;
    }

    /**
     * @return Collection|Referentiel[]
     */
    public function getReferentiels(): Collection
    {
        return $this->referentiels;
    }

    public function addReferentiel(Referentiel $referentiel): self
    {
        if (!$this->referentiels->contains($referentiel)) {
            $this->referentiels[] = $referentiel;
            $referentiel->addGroupeCompetence($this);
        }

        return $this;
    }

    public function removeReferentiel(Referentiel $referentiel): self
    {
        if ($this->referentiels->removeElement($referentiel)) {
            $referentiel->removeGroupeCompetence($this);
        }

        return $this;
    }
}
