<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"tag:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"tag:write"}},
 *      "pagination_items_per_page"=20
 * },
 *  collectionOperations={
 *      "get",
 *      "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can add tags",
 *      }
 * },
 *  itemOperations={
 *      "get",
 *      "put"
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
     * @Groups({"tag:read", "tag:write"})
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @Groups({"tag:read", "tag:write"})
     * @ORM\Column(type="string", length=100)
     */
    private $slug;

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
}
