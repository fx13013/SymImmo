<?php
namespace App\MailerNotification;

use App\Entity\Contact;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerNotification
{
    protected $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function notify(Contact $contact){
        $message = new TemplatedEmail();
        $message->from($contact->getEmail())
            ->to('noreply@agence.fr')
            ->subject('Agence : ' . $contact->getProperty()->getTitle())
            ->htmlTemplate('emails/contact.html.twig')
            ->context([
                'contact' => $contact
            ]);
        
        $this->mailer->send($message);
    }
}