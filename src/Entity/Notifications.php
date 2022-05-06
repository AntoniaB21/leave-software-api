<?php

namespace App\Entity;

use App\Repository\NotificationsRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 *  * @ApiResource(attributes={
 *      "normalization_context"={"groups"={"notifications:read", "enable_max_depth"=true}},
 *      "denormalization_context"={"groups"={"notifications:write"}},
 *      "pagination_items_per_page"=20
 *      },
 *      collectionOperations={
 *          "get"={
 *              "security"="is_granted('ROLE_ADMIN')",
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
 *              "security"="is_granted('ROLE_ADMIN')",
 *              "security_message"="Only admin can delete a tag",
 *          },
 *      }
 * )
 * @ORM\Entity(repositoryClass=NotificationsRepository::class)
 */
class Notifications
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
    private $message;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="notifications")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

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
}
