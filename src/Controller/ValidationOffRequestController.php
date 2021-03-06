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
            if ($to === 'accepted'){
                $dateDiff = date_diff($data->getDateEnd(), $data->getDateStart());
                $periodes = new \DatePeriod(
                    $data->getDateStart(),
                    new \DateInterval('P1D'),
                    $data->getDateEnd()->modify("+1 day")
                );
                $daysDiff = date_diff($data->getDateEnd(), $data->getDateStart())->days;
                foreach ($periodes as $periode) {
                    $dayOfWeek = $periode->format('D');
                    if ($dayOfWeek === "Sat" || $dayOfWeek === "Sun"){
                        --$daysDiff;
                    }
                }
                $user = $data->getUser();
                $user->setDaysTaken($user->getDaysTaken() + $daysDiff);
                $user->setDaysLeft($user->getDaysEarned() - $user->getDaysTaken());
            }
            $this->offRequestValidationStateMachine->apply($data, $to);
        }catch (LogicException $logicException){
            return $logicException;
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush();

        return $data;
    }
}