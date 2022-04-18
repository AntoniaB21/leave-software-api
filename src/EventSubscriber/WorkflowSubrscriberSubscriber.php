<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Workflow\Event\Event;



class WorkflowSubrscriberSubscriber implements EventSubscriberInterface
{
    // public function onWorkflowOffRequestValidationGuard(GuardEvent $event)
    // {
    //     $event->setBlocked(true, "I am not allowed to do this :(");
    // }
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function AfterStatusUpdated(Event $event){
        // envoyer un email quand le status est à jour
        dd($event->getSubject()->getUser()->getEmail());
        $destinataire = $event->getSubject()->getUser()->getEmail();
        $email = (new Email())
        ->to('admin282828@yopmail.fr')
        ->subject('Demande de congés')
        ->text('Salut tu as ta réponse de demande de congés');
        
        $this->mailer->send($email);
    }

    public static function getSubscribedEvents()
    {
        return [
            // 'workflow.off_request_validation.guard' => 'onWorkflowOffRequestValidationGuard',
            'workflow.off_request_validation.entered' => 'AfterStatusUpdated',
        ];
    }
}
