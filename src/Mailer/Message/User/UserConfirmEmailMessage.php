<?php

namespace App\Mailer\Message\User;

use App\Mailer\Message\DefaultMessage;

final class UserConfirmEmailMessage extends DefaultMessage
{
    public static function create(
        string $recipentEmail,
        string $username,
        string $confirmationUrl,
        string $senderEmail = null,
        string $senderName = null
    ): self
    {
        return new self(
            $recipentEmail,
            'email.confirm.subject',
            static::getMySubjectVars($username),
            'email.confirm.body',
            static::getMyTemplateVars($username, $confirmationUrl),
            $senderEmail,
            $senderName
        );
    }

    private static function getMySubjectVars(string $username): array
    {
        return [
            '{username}' => $username,
        ];
    }

    private static function getMyTemplateVars(
        string $username,
        string $confirmationUrl
    ): array
    {
        return [
            '{username}' => $username,
            '{confirmationUrl}' => $confirmationUrl,
        ];
    }
    
}
