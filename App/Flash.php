<?php declare(strict_types=1);

namespace App;

class Flash
{
    public static function add(string $message): void
    {
        if (! isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }

        $_SESSION['notifications'][] = $message;
    }

    public static function get(): array
    {
        if (! empty($_SESSION['notifications'])) {
            $messages = $_SESSION['notifications'];
            unset($_SESSION['notifications']);

            return $messages;
        }

        return [];
    }
}
