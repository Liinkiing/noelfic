<?php

namespace App\Mailer\Message;

abstract class Message
{
    protected $subject;
    protected $subjectVars;

    protected $template;
    protected $templateVars;

    protected $recipients;

    protected $senderEmail;
    protected $senderName;

    protected $cc;

    protected $bcc;
    protected $replyTo;
    protected $sitename;
    protected $siteUrl;

    final public function __construct(
        string $recipientEmail,
        string $subject,
        array $subjectVars,
        string $template,
        array $templateVars,
        string $senderEmail = null,
        string $senderName = null
    ) {
        $this->subject = $subject;
        $this->subjectVars = $subjectVars;
        $this->template = $template;
        $this->templateVars = $templateVars;


        $this->cc = [];
        $this->bcc = [];
        $this->recipients = [$recipientEmail];

        $this->senderEmail = $senderEmail;
        $this->senderName = $senderName;

    }

    abstract public function getFooterTemplate(): ?string;

    abstract public function getFooterVars(): ?array;

    public function getTemplateVars(): array
    {
        return $this->templateVars;
    }

    final public function addRecipient(string $recipientMail): self
    {
        $this->recipients[] = $recipientMail;

        return $this;
    }

    final public function getSubjectVars(): array
    {
        return $this->subjectVars;
    }

    final public function getSubject(): string
    {
        return $this->subject;
    }

    final public function getTemplate(): string
    {
        return $this->template;
    }

    final public function getRecipients(): array
    {
        return $this->recipients;
    }

    public function getSenderEmail(): ?string
    {
        return $this->senderEmail;
    }

    public function setSenderEmail(?string $senderEmail): self
    {
        $this->senderEmail = $senderEmail;

        return $this;
    }

    public function getSenderName(): ?string
    {
        return $this->senderName;
    }

    public function setSenderName(?string $senderName): self
    {
        $this->senderName = $senderName;

        return $this;
    }

    public function getCC(): array
    {
        return $this->cc;
    }

    public function addCC(string $cc): void
    {
        $this->cc[] = $cc;
    }

    public function setCC(array $cc): self
    {
        $this->cc = $cc;

        return $this;
    }

    public function getBcc(): array
    {
        return $this->bcc;
    }

    public function addBcc(string $bcc): void
    {
        $this->bcc[] = $bcc;
    }

    public function setBcc(array $bcc): self
    {
        $this->bcc = $bcc;

        return $this;
    }

    final protected static function escape(string $string): string
    {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8', false);
    }
}
