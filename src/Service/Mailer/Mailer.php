<?php

declare(strict_types=1);

namespace App\Service\Mailer;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class Mailer
{
    private MailerInterface $mailer;
    private string $fromAddress;

    public function __construct(MailerInterface $mailer, string $fromAddress)
    {
        $this->mailer = $mailer;
        $this->fromAddress = $fromAddress;
    }

    public function send(string $to, string $subject, string $body): void
    {
        $message = (new Email())
            ->from($this->fromAddress)
            ->to($to)
            ->subject($subject)
            ->html($body);

        $this->mailer->send($message);
    }

    public function sendWithAttachment(string $to, string $subject, string $body, array $attachments): void
    {
        $message = (new Email())
            ->from($this->fromAddress)
            ->to($to)
            ->subject($subject)
            ->html($body);

        foreach ($attachments as $attachment) {
            $message->attachFromPath($attachment);
        }

        $this->mailer->send($message);
    }
}
