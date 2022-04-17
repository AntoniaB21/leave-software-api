<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagChildRepository;
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
     * @Groups({"tagChild:read", "tagChild:write", "tag:read"})
     * 
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=350)
     * @Groups({"tagChild:read", "tagChild:write", "tag:read"})
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
     * @ORM\Column(type="float")
     * @Groups({"tagChild:read", "tagChild:write", "tag:read"})
     * 
     */
    private $maxBalance;

    /**
     * @ORM\Column(type="string", length=30)
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
}
