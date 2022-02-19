<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
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
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity=TagChildren::class, mappedBy="tag")
     */
    private $tagChildrens;

    public function __construct()
    {
        $this->tagChildrens = new ArrayCollection();
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
     * @return Collection|TagChildren[]
     */
    public function getTagChildrens(): Collection
    {
        return $this->tagChildrens;
    }

    public function addTagChildren(TagChildren $tagChildren): self
    {
        if (!$this->tagChildrens->contains($tagChildren)) {
            $this->tagChildrens[] = $tagChildren;
            $tagChildren->setTag($this);
        }

        return $this;
    }

    public function removeTagChildren(TagChildren $tagChildren): self
    {
        if ($this->tagChildrens->removeElement($tagChildren)) {
            // set the owning side to null (unless already changed)
            if ($tagChildren->getTag() === $this) {
                $tagChildren->setTag(null);
            }
        }

        return $this;
    }
}
