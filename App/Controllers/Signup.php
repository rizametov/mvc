<?php declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\User;
use App\Flash;

class Signup extends Controller
{
    public function indexAction(): void
    {
        $this->render('Signup/index', ['title' => 'Signup']);
    }

    public function validateAction(): void
    {
        $newUser = new User($_POST);

        if (true === $newUser->save()) {
            $newUser->sendActivationEmail();

            $this->redirect('/signup/created-success');
        } else {
            Flash::add('There are some errors, try again', Flash::DANGER);
            $this->render('Signup/index', ['title' => 'Signup', 'newUser' => $newUser]);
        }
    }

    public function createdSuccessAction(): void
    {
        $this->render('Signup/created-success', ['title' => 'Success']);
    }

    public function activateAction(): void
    {
        if (true === User::activateAccount($this->routeParams['token'])) {
            $this->render('Signup/activation-success', ['title' => 'Activation Success']);
        } else {
            $this->render('404');
        }
    }
}
