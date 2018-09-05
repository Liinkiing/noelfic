<?php


namespace App\Notifier;


use App\Mailer\MailerService;

abstract class Notifier
{

    protected $mailer;

    public function __construct(MailerService $mailer)
    {
        $this->mailer = $mailer;
    }

}