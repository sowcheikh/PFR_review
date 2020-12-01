<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiSubresource;
use App\Repository\ProfileSortieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *     attributes={
 *          "security_message"="Acces refusé vous n'avez pas l'autorisation"
 *     },
 *     collectionOperations={
 *          "get" = {
 *              "security"="is_granted('VIEW', object)",
 *              "path" = "/profilsorties",
 *              "method" = "GET"
 *          },
 *     },
 *      itemOperations={
 *
 *  }
 *
 * )
 * @ORM\Entity(repositoryClass=ProfileSortieRepository::class)
 */
class ProfileSortie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Libelle est obligatoire")
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archive = 0;

    /**
     * @ORM\OneToMany(targetEntity=Apprenant::class, mappedBy="profileSortie")
     * @ApiSubresource()
     */
    private $profile_de_sortie;

    public function __construct()
    {
        $this->profile_de_sortie = new ArrayCollection();
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
    public function getProfileDeSortie(): Collection
    {
        return $this->profile_de_sortie;
    }

    public function addProfileDeSortie(Apprenant $profileDeSortie): self
    {
        if (!$this->profile_de_sortie->contains($profileDeSortie)) {
            $this->profile_de_sortie[] = $profileDeSortie;
            $profileDeSortie->setProfileSortie($this);
        }

        return $this;
    }

    public function removeProfileDeSortie(Apprenant $profileDeSortie): self
    {
        if ($this->profile_de_sortie->removeElement($profileDeSortie)) {
            // set the owning side to null (unless already changed)
            if ($profileDeSortie->getProfileSortie() === $this) {
                $profileDeSortie->setProfileSortie(null);
            }
        }

        return $this;
    }
}
