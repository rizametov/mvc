<?php declare(strict_types=1);

namespace App;

use App\MailService;
use App\Config;

class Mail
{
    public function __construct(MailService $service)
    {
        $this->service = $service;
        $this->service->setKey(Config::MAIL_SERVICE_KEY);
        $this->domain = Config::MAIL_SERVICE_DOMAIN;
    }

    public function send(
        string $to, 
        string $subject, 
        string $text, 
        string $html
    ): void
    {
        $this->service->sendMessage(
            $this->domain,
            [
                'from' => Config::MAIL_ADDRESS,
                'to' => $to,
                'subject' => $subject,
                'text' => $text,
                'html' => $html,
            ]
        );
    }
}
