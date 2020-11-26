<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\BooleanFilter;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiFilter(BooleanFilter::class, properties={"archive"=false})
 * @ORM\InheritanceType("JOINED")
 * @DiscriminatorColumn(name="profil", type="string")
 * @DiscriminatorMap({"user" = "User", "admin" = "Admin", "apprenant" = "Apprenant", "formateur" ="Formateur", "cm" ="CM"})
 * @ApiResource(
 *     attributes={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Acces refusé vous n'avez pas l'autorisation",
 *          "input_formats"={"json"={"application/ld+json", "application/json"}},
 *          "output_formats"={"json"={"application/ld+json", "application/json"}}
 *     },
 *      collectionOperations={
 *          "getUsers" = {
 *              "path" = "/admin/users",
 *              "method" = "GET"
 *          },
 *          "addUsers" = {
 *              "path" = "/admin/users",
 *              "method" = "POST"
 *          },
 *     },
 *      itemOperations={
 *           "getUsersByID" = {
 *              "path" = "/admin/users/{id}",
 *              "method" = "GET",
 *              "requirements" = {"id"="\d+"},
 *            },
 *           "archiveUsers" = {
 *              "path" = "/admin/users/{id}",
 *              "method" = "DELETE",
 *              "requirements" = {"id"="\d+"},
 *     },
 *     "updateUsers" = {
 *              "path" = "/admin/users/{id}",
 *              "method" = "PUT",
 *              "requirements" = {"id"="\d+"}
 *      },
 *
 *  }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     *  @Assert\NotBlank(message="L'email est obligatoire")
     * @Assert\Email(
     *     message="Veuillez saisir un email valide."
     * )
     */
    protected $email;

    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Le password est obligatoire")
     */
    protected $password;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $profile;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    protected $avatar;

    /**
     * @ORM\Column(type="boolean")
     */
    private $archive = 0;

    /**
     * @ORM\Column(type="boolean")
     */
    private $statut = 0;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profile->getLibelle();

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getProfile(): ?Profil
    {
        return $this->profile;
    }

    public function setProfile(?Profil $profile): self
    {
        $this->profile = $profile;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

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

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
