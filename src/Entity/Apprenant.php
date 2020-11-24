<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ApprenantRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
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
     * @ORM\ManyToOne(targetEntity=ProfileSortie::class, inversedBy="profile_de_sortie")
     */
    private $profileSortie;

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
}
