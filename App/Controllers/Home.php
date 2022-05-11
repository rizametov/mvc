<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;

class Home extends controller
{
    public function indexAction()
    {
        View::render('Home/index.php', [
            'name' => 'Karl',
            'colors' => ['red', 'blue', 'green']
        ]);
    }
}
