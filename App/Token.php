<?php declare(strict_types=1);

namespace App;

use App\Config;

class Token
{
    private string $token;

    public function __construct(?string $token = null)
    {
        $this->token = $token ?? bin2hex(random_bytes(16));
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getHash(): string
    {
        return hash_hmac('sha256', $this->token, Config::SECRET_KEY);
    }
}