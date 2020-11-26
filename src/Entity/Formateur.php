<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\FormateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(
 *     collectionOperations={
 *        "GET"={
 *              "path"="/admin/users/formateurs"
 *         },
 *        "POST"={
 *              "path"="/admin/users/formateurs"
 *         }
 *      },
 *     itemOperations={
 *         "GET"={
 *              "path"="/admin/users/formateurs/{id}"
 *          },
 *         "PUT"={
 *              "path"="/admin/users/formateurs/{id}"
 *           },
 *          "DELETE"={
 *                "path"="/admin/users/formateurs/{id}"
 *            }
 *   }
 * )
 * @ORM\Entity(repositoryClass=FormateurRepository::class)
 */
class Formateur extends User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function getId(): ?int
    {
        return $this->id;
    }
}
