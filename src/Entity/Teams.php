<?php

namespace App\Entity;

use App\Repository\TeamsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"teams:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"teams:write"}},
 *      "pagination_items_per_page"=20
 * },
 *  collectionOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see teams list",
 *      },
 *      "post"={
 *          "security_message"="Only admin can add a teams",
 *      }
 * },
 *  itemOperations={
*       "get"={
*          "security"="is_granted('ROLE_ADMIN') or object == teams",
*          "security_message"= "You are not the owner of this profile",
*       }, 
 *      "put"={
 *          "security"="is_granted('ROLE_ADMIN') or object == teams",
 *          "security_message"="Only admin or owner can update detail",
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can delete a teams",
 *      },
 * })
 * @ORM\Entity(repositoryClass=TeamsRepository::class)
 */
class Teams
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"teams:read", "teams:read", "users:read"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"teams:read", "teams:read", "users:read"})
     * 
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="teams")
     */
    private $users;

    /**
     * @ORM\OneToOne(targetEntity=ValidationTemplate::class, mappedBy="team", cascade={"persist", "remove"})
     */
    private $validationTemplate;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $users): self
    {
        if (!$this->users->contains($users)) {
            $this->users[] = $users;
            $users->setTeams($this);
        }

        return $this;
    }

    public function removeUser(User $users): self
    {
        if ($this->users->removeElement($users)) {
            // set the owning side to null (unless already changed)
            if ($users->getTeams() === $this) {
                $users->setTeams(null);
            }
        }

        return $this;
    }

    public function getValidationTemplate(): ?ValidationTemplate
    {
        return $this->validationTemplate;
    }

    public function setValidationTemplate(ValidationTemplate $validationTemplate): self
    {
        // set the owning side of the relation if necessary
        if ($validationTemplate->getTeam() !== $this) {
            $validationTemplate->setTeam($this);
        }

        $this->validationTemplate = $validationTemplate;

        return $this;
    }
}
