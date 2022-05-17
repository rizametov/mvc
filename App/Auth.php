<?php declare(strict_types=1);

namespace App;

use App\Models\User;
use App\Models\RememberedLogin;

class Auth
{
    public static function login(User $user, bool $rememberMe = false): void
    {
        session_regenerate_id(true);
            
        $_SESSION['userId'] = $user->id;

        if (true === $user->rememberLogin()) {
            if (true === $rememberMe) {
                setcookie('remember_me', $user->token, $user->expiresAt, '/');
            }
        }
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

        static::forgetLogin();
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
        } else {
            return static::loginFromRememberCookie();
        }

        return null;
    }

    protected static function loginFromRememberCookie(): ?User
    {
        if (false !== ($cookie = $_COOKIE['remember_me'] ?? false)) {
            $rememberedLogin = RememberedLogin::getByToken($cookie);

            if (null !== $rememberedLogin && false === $rememberedLogin->isExpired()) {
                $user = $rememberedLogin->getUser();
                if (false !== $user) {
                    static::login($user);
    
                    return $user;
                }
            }
        }

        return null;
    }

    protected static function forgetLogin(): void
    {
        if (false !== ($cookie = $_COOKIE['remember_me'] ?? false)) {
            $rememberedLogin = RememberedLogin::getByToken($cookie);

            if (false !== ($rememberedLogin = RememberedLogin::getByToken($cookie))) {
                $rememberedLogin->delete();
            }

            setcookie('remember_me', '', time() - 3600, '/');
        }
    }
}
