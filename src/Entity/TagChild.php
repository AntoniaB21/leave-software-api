<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"tagChild:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"tagChild:write"}},
 *      "pagination_items_per_page"=20
 * },
 *  collectionOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see tag child list",
 *      },
 *      "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can add tag child",
 *      }
 * },
 *  itemOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see tag child detail",
 *      },
 *      "put"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can update tag child detail",
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can delete a tag",
 *      },
 * })
 * @ORM\Entity(repositoryClass=TagChildRepository::class)
 */
class TagChild
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"tagChild:read", "tagChild:write", "tag:read", "users:read","offRequest:read"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=350)
     * @Groups({"tagChild:read", "tagChild:write", "tag:read", "users:read"})
     * 
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"tagChild:read", "tagChild:write", "tag:read"})
     * 
     */
    private $description;

    /**
     * @ORM\Column(type="float", nullable=true)
     * @Groups({"tagChild:read", "tagChild:write", "tag:read"})
     * 
     */
    private $maxBalance;

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     * @Groups({"tagChild:read", "tagChild:write", "tag:read"})
     * 
     */
    private $measureUnit;

    /**
     * @ORM\ManyToOne(targetEntity=Tag::class, inversedBy="tagChildren")
     * @Groups({"tagChild:read","tagChild:write"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $tag;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="tagItems")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=OffRequest::class, mappedBy="offRequestType")
     */
    private $offRequests;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->offRequests = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getMaxBalance(): ?float
    {
        return $this->maxBalance;
    }

    public function setMaxBalance(float $maxBalance): self
    {
        $this->maxBalance = $maxBalance;

        return $this;
    }

    public function getMeasureUnit(): ?string
    {
        return $this->measureUnit;
    }

    public function setMeasureUnit(string $measureUnit): self
    {
        $this->measureUnit = $measureUnit;

        return $this;
    }

    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addTagItem($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeTagItem($this);
        }

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
            $offRequest->setOffRequestType($this);
        }

        return $this;
    }

    public function removeOffRequest(OffRequest $offRequest): self
    {
        if ($this->offRequests->removeElement($offRequest)) {
            // set the owning side to null (unless already changed)
            if ($offRequest->getOffRequestType() === $this) {
                $offRequest->setOffRequestType(null);
            }
        }

        return $this;
    }
}
