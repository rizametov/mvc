<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\User;
use App\Auth;
use App\Flash;

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

            Auth::login($user);

            Flash::add('Login successful!');

            $this->redirect(Auth::getReturnToPage());

        } else {

            Flash::add('Login unsuccessful, try again', Flash::WARNING);

            View::render('Login/index.php', ['email' => $_POST['email']]);
        }
    }

    public function logoutAction(): void
    {
        Auth::logout();

        $this->redirect('/login/show-logout-message');
    }

    public function showLogoutMessageAction(): void
    {
        Flash::add('Logout successful');
    
        $this->redirect('/');
    }
}
