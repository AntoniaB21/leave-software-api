<?php

namespace App\Controller;

use App\Entity\OffRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
Use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Workflow\Registry;
use Symfony\Component\Workflow\WorkflowInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Workflow\Exception\NotEnabledTransitionException;

class ValidationOffRequestController extends AbstractController
{
    private $security;
    private $registry;
    private $offRequestValidationStateMachine;
    private $entityManager;

    public function __construct(Security $security, Registry $registry, EntityManagerInterface $entityManager, WorkflowInterface $offRequestValidationStateMachine)
    {
        $this->security = $security;
        $this->registry = $registry;
        $this->entityManager = $entityManager;
        $this->offRequestValidationStateMachine = $offRequestValidationStateMachine;
    }
    
    public function __invoke(OffRequest $data, Request $request, String $to) : OffRequest
    {
        $workflow = $this->registry->get($data, 'off_request_validation');

        try {
            $this->offRequestValidationStateMachine->apply($data, $to);
        }catch (NotEnabledTransitionException $logicException){
            dd($logicException->getTransitionBlockerList());
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}