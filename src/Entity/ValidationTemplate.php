<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ValidationTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

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
 *          "security_message"="Only admin can see valid ation template detail",
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
     * @Groups({"validationTemplate:read","validationTemplate:write"})
     */
    private $team;

    /**
     * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"validationTemplate:read","validationTemplate:write"})
     * 
     */
    private $mainValidator;

    /**
     * @ORM\OneToMany(targetEntity=OffRequest::class, mappedBy="validationTemplate")
     * @Groups({"validationTemplate:read","validationTemplate:write"})
     * 
     */
    private $offsRequests;

    public function __construct()
    {
        $this->offsRequests = new ArrayCollection();
    }

    // /**
    //  * @ORM\OneToOne(targetEntity=User::class, cascade={"persist", "remove"})
    //  */
    // private $secondValidator;
    
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

    // public function getSecondValidator(): ?User
    // {
    //     return $this->secondValidator;
    // }

    // public function setSecondValidator(?User $secondValidator): self
    // {
    //     $this->secondValidator = $secondValidator;

    //     return $this;
    // }

    /**
     * @return Collection<int, OffRequest>
     */
    public function getOffsRequests(): Collection
    {
        return $this->offsRequests;
    }

    public function addOffsRequest(OffRequest $offsRequest): self
    {
        if (!$this->offsRequests->contains($offsRequest)) {
            $this->offsRequests[] = $offsRequest;
            $offsRequest->setValidationTemplate($this);
        }

        return $this;
    }

    public function removeOffsRequest(OffRequest $offsRequest): self
    {
        if ($this->offsRequests->removeElement($offsRequest)) {
            // set the owning side to null (unless already changed)
            if ($offsRequest->getValidationTemplate() === $this) {
                $offsRequest->setValidationTemplate(null);
            }
        }

        return $this;
    }
}
