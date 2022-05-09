<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiSubresource;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"tag:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"tag:write"}},
 *      "pagination_items_per_page"=20
 * },
 *  collectionOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see tags list",
 *      },
 *      "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can add tags",
 *      }
 * },
 *  itemOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see tag detail",
 *      },
 *      "put"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can update tag detail",
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can delete a tag",
 *      },
 * })
 * @ORM\Entity(repositoryClass=TagRepository::class)
 */
class Tag
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"tag:read", "tag:write", "tagChild:read"})
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @Groups({"tag:read", "tag:write", "tagChild:read"})
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

    /**
     * @Groups({"tag:read"})
     * @ORM\OneToMany(targetEntity=TagChild::class, mappedBy="tag")
     * @ApiSubresource()
     * 
     */
    private $tagChildren;

    public function __construct()
    {
        $this->tagChildren = new ArrayCollection();
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
     * @return Collection<int, TagChild>
     */
    public function getTagChildren(): Collection
    {
        return $this->tagChildren;
    }

    public function addTagChild(TagChild $tagChild): self
    {
        if (!$this->tagChildren->contains($tagChild)) {
            $this->tagChildren[] = $tagChild;
            $tagChild->setTag($this);
        }

        return $this;
    }

    public function removeTagChild(TagChild $tagChild): self
    {
        if ($this->tagChildren->removeElement($tagChild)) {
            // set the owning side to null (unless already changed)
            if ($tagChild->getTag() === $this) {
                $tagChild->setTag(null);
            }
        }

        return $this;
    }
}
