<?php declare(strict_types=1);

namespace App;

class MailService 
{
    private string $key;

    public function setKey(string $key): void
    {
        $this->key = $key;
    }

    public function sendMessage(string $domain, array $params): void {}
}
