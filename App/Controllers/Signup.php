<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\User;
use App\Flash;

class Signup extends Controller
{
    public function indexAction(): void
    {
        View::render('Signup/index.php');
    }

    public function validateAction(): void
    {
        $newUser = new User($_POST);

        if (true === $newUser->save()) {
            Flash::add('Successful sign up!');
            $this->redirect('/signup/success');
        } else {
            Flash::add('There are some errors, try again', Flash::DANGER);
            View::render('Signup/index.php', ['newUser' => $newUser]);
        }
    }

    public function successAction(): void
    {
        View::render('Signup/success.php');
    }
}
