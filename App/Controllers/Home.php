<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Auth;

class Home extends Controller
{
    public function indexAction(): void
    {
        $this->render('Home/index');
    }
}
