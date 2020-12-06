<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *        "GET"={
 *              "path"="/admin/users/apprenants",
 *              "security"="is_granted('APP_VIEW_ALL', object)",
 *              "security_message"="Vous n'avez pas accès"
 *         },
 *        "POST"={
 *              "path"="/admin/users/apprenants"
 *         }
 *      },
 *     itemOperations={
 *         "GET"={
 *              "path"="/admin/users/apprenants/{id}",
 *              "security"="is_granted('APP_VIEW', object)",
 *              "security_message"="Vous n'avez pas accès"
 *          },
 *         "PUT"={
 *              "path"="/admin/users/apprenants/{id}"
 *           }
 *       }
 * )
 * @ORM\Entity(repositoryClass=ApprenantRepository::class)
 */
class Apprenant extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity=ProfileSortie::class, inversedBy="profile_de_sortie", cascade={"persist"})
     */
    private $profileSortie;

    /**
     * @ORM\ManyToMany(targetEntity=Groupe::class, mappedBy="apprenant", cascade={"persist"})
     */
    private $groupes;

    public function __construct()
    {
        $this->groupes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProfileSortie(): ?ProfileSortie
    {
        return $this->profileSortie;
    }

    public function setProfileSortie(?ProfileSortie $profileSortie): self
    {
        $this->profileSortie = $profileSortie;

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
            $groupe->addApprenant($this);
        }

        return $this;
    }

    public function removeGroupe(Groupe $groupe): self
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeApprenant($this);
        }

        return $this;
    }
}
