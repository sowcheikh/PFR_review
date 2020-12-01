<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\GroupeTagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     routePrefix="/admin",
 *     collectionOperations={
 *          "getGrpTags"={
 *              "method" = "GET",
 *              "path" = "/grptags",
 *              "normalization_context"={"groups"={"tags:read"}}
 *          },
 *          "addGrpTags"={
 *              "method" = "POST",
 *              "path" = "/grptags",
 *              "normalization_context"={"groups"={"tags:read"}}
 *          },
 *     },
 *     itemOperations={
 *          "getGrpTagsByID"={
 *              "method" = "GET",
 *              "path" = "/grptags/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"tags:read"}}
 *          },
 *     "getTagsInGrpTagsByID"={
 *              "method" = "GET",
 *              "path" = "/grptags/{id}/tags",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"tags:read"}}
 *          },
 *          "setGrpTags"={
 *              "method" = "PUT",
 *              "path" = "/grptags/{id}",
 *              "requirements"={"id"="\d+"},
 *              "normalization_context"={"groups"={"tags:read"}}
 *          },
 *     }
 * )
 * @ORM\Entity(repositoryClass=GroupeTagRepository::class)
 */
class GroupeTag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"tags:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Groups({"tags:read"})
     */
    private $archive = 0;

    /**
     * @ORM\ManyToMany(targetEntity=Tag::class, inversedBy="groupeTags", cascade={"persist"})
     * @Groups({"tags:read"})
     */
    private $tags;

    public function __construct()
    {
        $this->tags = new ArrayCollection();
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
     * @return Collection|Tag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
        }

        return $this;
    }

    public function removeTag(Tag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
