<?php


namespace App\Notifier;


use App\Entity\User;
use App\Mailer\MailerService;
use App\Mailer\Message\User\UserConfirmEmailMessage;
use App\Resolver\UserResolver;

class UserNotifier extends Notifier
{

    private $resolver;

    public function __construct(MailerService $mailer, UserResolver $resolver)
    {
        parent::__construct($mailer);
        $this->resolver = $resolver;
    }

    public function onConfirmEmail(User $user): void
    {
        $this->mailer->sendMessage(UserConfirmEmailMessage::create(
            $user->getEmail(),
            $user->getUsername(),
            $this->resolver->resolveConfirmationUrl($user)
        ));
    }

}