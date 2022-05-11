<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\User;

class Signup extends Controller
{
    public function indexAction(): void
    {
        View::render('Signup/index.php');
    }

    public function validateAction(): void
    {
        $user = new User($_POST);

        if (true === $user->save()) {
            $this->redirect('/signup/success');
        } else {
            View::render('Signup/index.php', ['user' => $user]);
        }
    }

    public function successAction(): void
    {
        View::render('Signup/success.php');
    }
}
