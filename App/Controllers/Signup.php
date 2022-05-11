<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\User;

class Signup extends Controller
{
    public function newAction()
    {
        View::render('Signup/new.php');
    }

    public function createAction()
    {
        $user = new User($_POST);

        if (true === $user->save()) {
            $this->redirect('/signup/success');
        } else {
            View::render('Signup/new.php', ['user' => $user]);
        }
    }

    public function successAction()
    {
        View::render('Signup/success.php');
    }
}
