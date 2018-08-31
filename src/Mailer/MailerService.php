<?php

namespace App\Mailer;

use App\Mailer\Message\Message;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Twig\Environment;

class MailerService
{
    protected $mailer;
    protected $templating;
    protected $translator;
    private $parameters;

    public function __construct(
        ParameterBagInterface $parameters,
        \Swift_Mailer $mailer,
        Environment $templating,
        TranslatorInterface $translator
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->translator = $translator;
        $this->parameters = $parameters;
    }

    public function sendMessage(Message $message): void
    {
        if (!$message->getSenderEmail()) {
            $senderEmail = $this->parameters->get('default_sender_address');
            $senderName = $this->parameters->get('default_sender_name');
            $message->setSenderEmail($senderEmail);
            $message->setSenderName($senderName);
        }

        $subject = $this->translator->trans($message->getSubject(), $message->getSubjectVars());

        $template = $message->getTemplate();
        if (false !== strpos($template, '.twig')) {
            $body = $this->templating->render(
                $message->getTemplate(),
                $message->getTemplateVars()
            );
        } else {
            $body = $this->translator->trans($template, $message->getTemplateVars());
        }
        if ($message->getFooterTemplate()) {
            if (false !== strpos($message->getFooterTemplate(), '.twig')) {
                $body .= $this->templating->render(
                    $message->getFooterTemplate(),
                    $message->getFooterVars()
                );
            } else {
                $body .= $this->translator->trans($message->getFooterTemplate(), $message->getFooterVars());
            }
        }
        $swiftMessage = (new \Swift_Message())
            ->setSubject($subject)
            ->setContentType('text/html')
            ->setBody($body)
            ->setFrom([
                $message->getSenderEmail() => $message->getSenderName(),
            ]);

        if (!empty($message->getBcc())) {
            $swiftMessage->setBcc($message->getBcc());
        }
        if (!empty($message->getCC())) {
            $swiftMessage->setCc($message->getCC());
        }
        foreach ($message->getRecipients() as $recipient) {
            $swiftMessage->addTo($recipient);
        }

        $this->mailer->send($swiftMessage);
    }
}
