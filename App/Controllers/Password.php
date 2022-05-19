<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\User;
use App\Auth;
use App\Flash;

class Password extends Controller
{
    public function fogotAction(): void
    {
        View::render('Password/fogot.php');
    }

    public function requestResetAction(): void
    {   
        if (false !== $user = User::getByEmail($_POST['email'])) {
            $user->sendPasswordReset();
            View::render('Password/reset-requested.php');
        } else {          
            View::render('404.php');
        }
    }

    public function resetAction(): void
    {
        $token = $this->routeParams['token'];
        $user = $this->getUserByToken($token);

        View::render('Password/reset.php', ['token' => $token]);
    }

    public function resetPasswordAction(): void
    {
        $token = $_POST['token'];

        $user = $this->getUserByToken($token);

        if (true === $user->resetPassword($_POST['password'], $_POST['passwordConfirmation'])) {
            Flash::add('Password was successful reset');
            $this->redirect('/login/index');
        } else {
            Flash::add('There are some errors', Flash::WARNING);
            View::render('Password/reset.php', ['token' => $token, 'errors' => $user->getErrors()]);
        } 
    }

    private function getUserByToken(string $token): User
    {
        if (false !== $user = User::getByToken($token)) {
            return $user;
        } else {
            View::render('Password/token-expired.php');
            exit;
        }
    }
}
