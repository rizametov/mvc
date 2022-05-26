<?php declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Auth;
use App\Flash;

class Password extends Controller
{
    public function fogotAction(): void
    {
        $this->render('Password/fogot', ['title' => 'Password Fogot']);
    }

    public function requestResetAction(): void
    {   
        if (false !== $user = User::getByEmail($_POST['email'])) {
            $user->sendPasswordReset();
            $this->render('Password/reset-requested', ['title' => 'Password Reset']);
        } else {          
            $this->render('404');
        }
    }

    public function resetAction(): void
    {
        $token = $this->routeParams['token'];
        $user = $this->getUserByToken($token);

        $this->render('Password/reset', ['title' => 'Password Reset', 'token' => $token]);
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
            $this->render('Password/reset', [
                'title' => 'Password Reset',
                'token' => $token, 
                'errors' => $user->getErrors()
            ]);
        } 
    }

    private function getUserByToken(string $token): User
    {
        if (false !== $user = User::getByToken($token)) {
            return $user;
        } else {
            $this->render('Password/token-expired', ['title' => 'Password Expired']);
            exit;
        }
    }
}
