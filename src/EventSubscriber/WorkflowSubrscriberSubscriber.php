<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;
class WorkflowSubrscriberSubscriber implements EventSubscriberInterface
{
    public function onWorkflowOffRequestValidationGuard(GuardEvent $event)
    {
        $event->setBlocked(true, "I am not allowed to do this :(");
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.off_request_validation.guard' => 'onWorkflowOffRequestValidationGuard',
        ];
    }
}
