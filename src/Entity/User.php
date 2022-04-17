<?php

namespace App\Entity;

use App\Entity\Teams;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"users:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"users:write"}},
 *      "pagination_items_per_page"=20
 * },
 *  collectionOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see user list",
 *      },
 *      "post"={
 *          "security_message"="Only admin can add a user",
 *      }
 * },
 *  itemOperations={
*       "get"={
*          "security"="is_granted('ROLE_ADMIN') or object == user",
*          "security_message"= "You are not the owner of this profile",
*       }, 
 *      "put"={
 *          "security"="is_granted('ROLE_ADMIN') or object == user",
 *          "security_message"="Only admin or owner can update detail",
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can delete a user",
 *      },
 * })
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"users:read", "users:write"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"users:write"})
     * 
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @Groups("users:write")
     * @SerializedName("password")
     */
    private $plainPassword;

    /**
     * @ORM\OneToMany(targetEntity=OffRequest::class, mappedBy="user")
     * @Groups({"users:read"})
     * 
     */
    private $offRequests;

    /**
     * @ORM\ManyToOne(targetEntity=Teams::class, inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"users:read", "users:write"})
     * 
     */
    private $teams;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"users:read", "users:write"})
     */
    private $dateEntrance;

    /**
     * @ORM\ManyToMany(targetEntity=TagChild::class, inversedBy="users")
     * @Groups({"users:read"})
     */
    private $tagItems;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $daysEarned;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $daysTaken;

    /**
     * @ORM\Column(type="float",nullable=true)
     */
    private $daysLeft;

    public function __construct()
    {
        $this->offRequests = new ArrayCollection();
        $this->tagItems = new ArrayCollection();
        $this->dateEntrance = new \DateTime();
        $this->roles = new ArrayCollection(['ROLE_USER']);
        $this->daysEarned = 0.0;
        $this->daysTaken = 0.0;
        $this->daysLeft = 0.0;
    }

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
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
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
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getPlainPassword(): ?string
    {
        return $this->plainPassword;
    }
    public function setPlainPassword(string $plainPassword): self
    {
        $this->plainPassword = $plainPassword;
        return $this;
    }

    /**
     * @return Collection<int, OffRequest>
     */
    public function getOffRequests(): Collection
    {
        return $this->offRequests;
    }

    public function addOffRequest(OffRequest $offRequest): self
    {
        if (!$this->offRequests->contains($offRequest)) {
            $this->offRequests[] = $offRequest;
            $offRequest->setUser($this);
        }

        return $this;
    }

    public function removeOffRequest(OffRequest $offRequest): self
    {
        if ($this->offRequests->removeElement($offRequest)) {
            // set the owning side to null (unless already changed)
            if ($offRequest->getUser() === $this) {
                $offRequest->setUser(null);
            }
        }

        return $this;
    }

    public function getTeams(): ?Teams
    {
        return $this->teams;
    }

    public function setTeams(?Teams $teams): self
    {
        $this->teams = $teams;

        return $this;
    }

    public function getDateEntrance(): ?\DateTimeInterface
    {
        return $this->dateEntrance;
    }

    public function setDateEntrance(\DateTimeInterface $dateEntrance): self
    {
        $this->dateEntrance = $dateEntrance;

        return $this;
    }

    /**
     * @return Collection<int, TagChild>
     */
    public function getTagItems(): Collection
    {
        return $this->tagItems;
    }

    public function addTagItem(TagChild $tagItem): self
    {
        if (!$this->tagItems->contains($tagItem)) {
            $this->tagItems[] = $tagItem;
        }

        return $this;
    }

    public function removeTagItem(TagChild $tagItem): self
    {
        $this->tagItems->removeElement($tagItem);

        return $this;
    }

    public function getDaysEarned(): ?float
    {
        return $this->daysEarned;
    }

    public function setDaysEarned(float $daysEarned): self
    {
        $this->daysEarned = $daysEarned;

        return $this;
    }

    public function getDaysTaken(): ?float
    {
        return $this->daysTaken;
    }

    public function setDaysTaken(float $daysTaken): self
    {
        $this->daysTaken = $daysTaken;

        return $this;
    }

    public function getDaysLeft(): ?float
    {
        return $this->daysLeft;
    }

    public function setDaysLeft(float $daysLeft): self
    {
        $this->daysLeft = $daysLeft;

        return $this;
    }
}
