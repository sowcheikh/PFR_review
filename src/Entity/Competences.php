<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CompetencesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "getCompetences"={
 *              "method" = "GET",
 *              "path" = "/admin/competences",
 *              "normalization_context"={"groups"={"competences:read"}}
 *          },
 *          "post"={
 *              "method" = "POST",
 *              "path" = "/admin/competences",
 *              "normalization_context"={"groups"={"competence:read"}}
 *          },
 *     },
 *     itemOperations={
 *          "getCompetenceByID"={
 *              "method" = "GET",
 *              "path" = "/admin/competences/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"competence:read"}}
 *          },
 *          "set_competence"={
 *              "method" = "PUT",
 *              "path" = "/admin/competences/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"competence:read"}}
 *          },
 *     }
 * )
 * @ORM\Entity(repositoryClass=CompetencesRepository::class)
 */
class Competences
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="Le libelle est obligatoire"
     * )
     * @Groups({"competence:read", "grpecompetence:competence:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *     message="Le descriptif est obligatoire"
     * )
     * @Groups({"competence:read", "grpecompetence:competence:read"})
     */
    private $descriptif;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"competence:read", "grpecompetence:competence:read"})
     */
    private $archive = 0;

    /**
     * @ORM\ManyToMany(targetEntity=GroupeCompetences::class, mappedBy="competence", cascade={"persist"})
     * @Assert\NotBlank(
     *     message="Une competence est dans au moins un groupe de competence"
     * )
     * @Groups({"competence:read"})
     */
    private $groupeCompetences;

    /**
     * @ORM\OneToMany(targetEntity=Niveau::class, mappedBy="competence", cascade={"persist"})
     * @Assert\NotNull(
     *     message="Les niveaux d'évaluation sont obligatoires"
     * )
     * @Groups({"competence:read", "grpecompetence:competence:read"})
     */
    private $niveaux;

    public function __construct()
    {
        $this->groupeCompetences = new ArrayCollection();
        $this->niveaux = new ArrayCollection();
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

    public function getDescriptif(): ?string
    {
        return $this->descriptif;
    }

    public function setDescriptif(string $descriptif): self
    {
        $this->descriptif = $descriptif;

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
    public function getGroupeCompetences(): Collection
    {
        return $this->groupeCompetences;
    }

    public function addGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if (!$this->groupeCompetences->contains($groupeCompetence)) {
            $this->groupeCompetences[] = $groupeCompetence;
            $groupeCompetence->addCompetence($this);
        }

        return $this;
    }

    public function removeGroupeCompetence(GroupeCompetences $groupeCompetence): self
    {
        if ($this->groupeCompetences->removeElement($groupeCompetence)) {
            $groupeCompetence->removeCompetence($this);
        }

        return $this;
    }

    /**
     * @return Collection|Niveau[]
     */
    public function getNiveaux(): Collection
    {
        return $this->niveaux;
    }

    public function addNiveau(Niveau $niveau): self
    {
        if (!$this->niveaux->contains($niveau)) {
            $this->niveaux[] = $niveau;
            $niveau->setCompetence($this);
        }

        return $this;
    }

    public function removeNiveau(Niveau $niveau): self
    {
        if ($this->niveaux->removeElement($niveau)) {
            // set the owning side to null (unless already changed)
            if ($niveau->getCompetence() === $this) {
                $niveau->setCompetence(null);
            }
        }

        return $this;
    }
}
