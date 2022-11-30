<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ClientUserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\ClientUsersCreateController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ClientUserRepository::class)
 * @UniqueEntity("email", message = "L'email pour cet utilisateur existe déjà")
 * 
 * @ApiResource(
 *     itemOperations={
 *          "get",
 *          "delete"
 *     },
 *     normalizationContext={
 *          "groups"={"read:client"}
 *     },
*     denormalizationContext={
 *          "groups"={"create:clientUser"}
 *     },
 *     collectionOperations={
 *          "get",
 *          "create_client_users"={
 *              "method" : "POST",
 *              "path" : "/client_users",
 *              "controller" : ClientUsersCreateController::class,
 *              "openapi_context":{
 *                  "summary" : "Client creation"
 *              }
 *          }
 *      },
 *      paginationItemsPerPage=3,
 *      maximumItemsPerPage=5,
 *      paginationClientItemsPerPage=true,
 *      security="is_granted('ROLE_ADMIN')"
 * )
 */
class ClientUser
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * 
     * @Groups({"read:client"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="clientUsers", cascade={"persist"})
     * 
     * @Groups({"read:client"})
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 15,
     *      minMessage = "Le prénom est trop court, {{ limit }} caractéres minimum",
     *      maxMessage = "Le prénom est trop long, {{ limit }} caractéres maximum"
     * )
     * 
     * @Groups({"read:client", "create:clientUser"})
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 15,
     *      minMessage = "Le nom est trop court, {{ limit }} caractéres minimum",
     *      maxMessage = "Le nom est trop long, {{ limit }} caractéres maximum"
     * )
     * 
     * @Groups({"read:client", "create:clientUser"})
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     * @Assert\NotBlank
     * @Assert\Email(
     *     message = "L'email '{{ value }}' n'est pas valide"
     * )
     * @Groups({"read:client", "create:clientUser"})
     */
    private $email;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"read:client"})
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     * 
     * @Groups({"read:client"})
     */
    private $updated_at;

    public function __construct()
    {
        date_default_timezone_set('Europe/Paris');
        $this->created_at = new \Datetime();
        $this->updated_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
