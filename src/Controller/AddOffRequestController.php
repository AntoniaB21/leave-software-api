<?php

namespace App\Controller;

use App\Entity\OffRequest;
use App\Entity\ValidationTemplate;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ValidationTemplateRepository;
use App\Repository\UserRepository;

class AddOffRequestController extends AbstractController
{
    private $entityManager;
    private $security;
    private $validationTemplateRepository;
    private $userRepository;

    public function __construct(Security $security, EntityManagerInterface $entityManager, ValidationTemplateRepository $validationTemplateRepository, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->security = $security;
        $this->validationTemplateRepository = $validationTemplateRepository;
        $this->userRepository = $userRepository;
    }

    public function __invoke(OffRequest $data, Request $request): OffRequest
    {
        $user = $data->getUser();
        $validationTemplate = $this->validationTemplateRepository->findOneByTeam($user->getTeams()->getId());

        if ($validationTemplate === null) {
            $admin = $this->userRepository->findOneByRoles('ROLE_ADMIN');
            $data->setValidator($admin);
        } else { 
            $data->setValidator($validationTemplate->getMainValidator()); $data->setValidationTemplate($validationTemplate);
        }
        
        $this->entityManager->persist($data);
        $this->entityManager->flush();
        return $data;
    }
}