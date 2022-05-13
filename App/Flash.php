<?php declare(strict_types=1);

namespace App;

class Flash
{
    public const SUCCESS = 'success';

    public const WARNING = 'warning';

    public const DANGER = 'danger';

    public static function add(string $message, string $type = self::SUCCESS): void
    {
        if (! isset($_SESSION['notifications'])) {
            $_SESSION['notifications'] = [];
        }

        $_SESSION['notifications'][] = [
            'message' => $message,
            'type' => $type
        ];
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
