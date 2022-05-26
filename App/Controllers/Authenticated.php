<?php declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;

abstract class Authenticated extends Controller
{
    protected string $layout = 'authenticated';

    protected function before(): void
    {
        $this->requireLogin();
    }
}
