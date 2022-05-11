<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\User;

class Login extends Controller
{
    public function indexAction(): void
    {
        View::render('Login/index.php');
    }

    public function validateAction(): void
    {
        $user = User::authenticate($_POST['email'], $_POST['password']);

        if (false !== $user) {
            $this->redirect('/');
        }

        View::render('Login/index.php', ['email' => $_POST['email']]);
    }
}
