<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ValidationTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ValidationTemplateRepository::class)
 */
class ValidationTemplate
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="array")
     */
    private $tags = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $validator2 = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $validator1 = [];

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $validator3 = [];
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getValidator2(): ?array
    {
        return $this->validator2;
    }

    public function setValidator2(array $validator2): self
    {
        $this->validator2 = $validator2;

        return $this;
    }

    public function getValidator1(): ?array
    {
        return $this->validator1;
    }

    public function setValidator1(array $validator1): self
    {
        $this->validator1 = $validator1;

        return $this;
    }

    public function getValidator3(): ?array
    {
        return $this->validator3;
    }

    public function setValidator3(?array $validator3): self
    {
        $this->validator3 = $validator3;

        return $this;
    }
}
