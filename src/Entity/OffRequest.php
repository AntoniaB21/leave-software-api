<?php

namespace App\Entity;

use App\Repository\OffRequestRepository;
use Doctrine\ORM\Mapping as ORM;
use App\Controller\ValidationOffRequestController;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"offRequest:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"offRequest:write"}},
 *      "pagination_items_per_page"=20
 *      },
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN') or object.user == user",
 *              "security_message"="Only admin or owner of the request can see offRequests list",
 *           },
 *          "transitionEvent"={
 *               "method"="GET",
 *               "security"="is_granted('ROLE_MANAGER') or is_granted('ROLE_ADMIN') ",
 *               "path"="/off_requests/{id}/{to}",
 *               "controller"=ValidationOffRequestController::class,
 *               "security_message"="Only admin or manager can validate Off Request",
 *               "read"=false,
 *               "defaults"={"_api_receive"=false}
 *          },
 *          "post"={
 *              "security"="is_granted('ROLE_USER')",
 *              "security_message"="Only logged-in users can add off request",
 *          }
 *      },
 *      itemOperations={
 *          "get"={
*          "security"="is_granted('ROLE_ADMIN') or object == user",
 *              "security_message"="Only admin can see tag detail",
 *          },
 *          "put"={
 *               "security"="is_granted('ROLE_ADMIN') or object == user",
 *              "security_message"="Only admin can update tag detail",
 *          },
 *         
 *          "delete"={
 *              "security"="is_granted('ROLE_ADMIN') or object.user == user",
 *              "security_message"="Only admin can delete a tag",
 *          },
 *      }
 * )
 * @ORM\Entity(repositoryClass=OffRequestRepository::class)
 */
class OffRequest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"offRequest:read","offRequest:write", "users:read"})
     * @Assert\GreaterThan("today")
     * @ORM\Column(type="datetime")
     */
    private $dateStart;

    /**
     * @Groups({"offRequest:read","offRequest:write", "users:read"})
     * @Assert\GreaterThan("today")
     * @Assert\Expression(
     *     "this.getDateStart() < this.getDateEnd()",
     *     message="La date de fin doit être supérieure à la date de début"
     *  )
     * @ORM\Column(type="datetime")
     */
    private $dateEnd;

    /**
     * @Groups({"offRequest:read","offRequest:write", "users:read"})
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $comments;

    /**
     * @Groups({"offRequest:read","offRequest:write"})
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="offRequests")
     */
    private $user;

    /**
     * @Assert\Choice({"draft", "pending", "accepted","rejected", "users:read"})
     * @Groups({"offRequest:read"})
     * @ORM\Column(type="string", length=20)
     */
    private $status;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct() {
        $this->status = "draft";
        $this->createdAt = new \Datetime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateStart(): ?\DateTimeInterface
    {
        return $this->dateStart;
    }

    public function setDateStart(\DateTimeInterface $dateStart): self
    {
        $this->dateStart = $dateStart;

        return $this;
    }

    public function getDateEnd(): ?\DateTimeInterface
    {
        return $this->dateEnd;
    }

    public function setDateEnd(\DateTimeInterface $dateEnd): self
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function getComments(): ?string
    {
        return $this->comments;
    }

    public function setComments(?string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
