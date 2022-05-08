<?php

namespace App\EventSubscriber;

use App\Entity\Notifications;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\GuardEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Workflow\Event\Event;
use Doctrine\ORM\EntityManagerInterface;



class WorkflowSubrscriberSubscriber implements EventSubscriberInterface
{
    // public function onWorkflowOffRequestValidationGuard(GuardEvent $event)
    // {
    //     $event->setBlocked(true, "I am not allowed to do this :(");
    // }
    private $mailer;
    private $entityManager;

    public function __construct(MailerInterface $mailer, EntityManagerInterface $entityManager)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;

    }

    public function AcceptedStatusUpdated(Event $event){
        // envoyer un email quand le status est à jour
        $destinataire = $event->getSubject()->getUser()->getEmail();

        // NE PAS SUPPRILER
        // $email = (new Email())
        // ->from('antonia.balluais@vmed.fr')
        // ->to('admin282828@yopmail.fr')
        // ->subject('Demande de congés '. $event->getSubject()->getStatus())
        // ->text('Votre demande de congés a été '. $event->getSubject()->getStatus());
        // $this->mailer->send($email);

        // create notification
        $notification = new Notifications();
        $notification->setMessage('Votre demande de congés a été '. $event->getSubject()->getStatus());
        $notification->setUser($event->getSubject()->getUser());
        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    public function DaysLeftUpdated(Event $event){
        // dd($event->getSubject());
        $offRequest = $event->getSubject();
        $user = $event->getSubject()->getUser();
        $this->entityManager->persist($user);
        $this->entityManager->persist($offRequest);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents()
    {
        return [
            'workflow.off_request_validation.entered' => 'AcceptedStatusUpdated',
            'workflow.off_request_validation.completed.accepted' => 'DaysLeftUpdated',
        ];
    }
}
