<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ValidationTemplateRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"validationTemplate:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"validationTemplate:write"}},
 *      "pagination_items_per_page"=20
 * },
 *  collectionOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see all validation templates",
 *      },
 *      "post"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can add a validation template",
 *      }
 * },
 *  itemOperations={
 *      "get"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can see validation template detail",
 *      },
 *      "put"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can update validation template detail",
 *      },
 *      "delete"={
 *          "security"="is_granted('ROLE_ADMIN')",
 *          "security_message"="Only admin can delete a tag",
 *      },
 * })
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
     * @ORM\OneToOne(targetEntity=Teams::class, inversedBy="validationTemplate", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $team;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainValidator;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     */
    private $secondValidator;
    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Teams
    {
        return $this->team;
    }

    public function setTeam(Teams $team): self
    {
        $this->team = $team;

        return $this;
    }

    public function getMainValidator(): ?User
    {
        return $this->mainValidator;
    }

    public function setMainValidator(User $mainValidator): self
    {
        $this->mainValidator = $mainValidator;

        return $this;
    }

    public function getSecondValidator(): ?User
    {
        return $this->secondValidator;
    }

    public function setSecondValidator(?User $secondValidator): self
    {
        $this->secondValidator = $secondValidator;

        return $this;
    }
}
