<?php

namespace App\Controller;

use App\Entity\OffRequest;
use App\Entity\User;
use App\Entity\ValidationTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\UserRepository;
use App\Repository\OffRequestRepository;

class ValidationListController
{
    private $offRequestRepository;

    public function __construct(OffRequestRepository $offRequestRepository)
    {
        $this->offRequestRepository = $offRequestRepository;
    }

    public function __invoke(User $data)
    {
        return $this->takeValidationList($data);
    }

    private function takeValidationList(User $user)
    {
        if (in_array('ROLE_ADMIN', $user->getRoles())){
            return $this->offRequestRepository->findAll();
        }
        return $this->offRequestRepository->getValidationListByManager($user->getId());
    }
}
