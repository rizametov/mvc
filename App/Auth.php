<?php declare(strict_types=1);

namespace App;

use App\Models\User;

class Auth
{
    public static function login(User $user): void
    {
        session_regenerate_id(true);
            
        $_SESSION['userId'] = $user->id;
    }

    public static function logout(): void
    {
        $_SESSION = [];

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        session_destroy();
    }

    public static function rememberRequestedPage(): void
    {
        $_SESSION['return_to'] = $_SERVER['REQUEST_URI'];
    }

    public static function getReturnToPage(): string
    {
        return $_SESSION['return_to'] ?? '/';
    }

    public static function getUser(): ?User
    {
        if (isset($_SESSION['userId'])) {
            return false !== ($user = User::getById($_SESSION['userId'])) ? $user : null;
        }

        return null;
    }
}
