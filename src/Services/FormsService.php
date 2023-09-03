<?php

namespace App\Services;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class FormsService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function send(string $from, string $to, string $subject, string $template, array $context): void {
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate("emails/$template.html.twig")
            ->context($context);

        try {
            $this->mailer->send($email);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function validateRegister(string $userMail, string $user, string $token){
        $this->send(
            'no-reply@creative-eye.fr',
            $userMail,
            "Création de votre compte sur le site",
            'register',
            compact($user, $token)
        );
    }
}
