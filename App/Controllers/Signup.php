<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;

class Signup extends Controller
{
    public function newAction()
    {
        View::render('Signup/new.php');
    }
}
