<?php declare(strict_types=1);

namespace App\Controllers;

use \Core\View;

class Home extends \Core\Controller
{
    public function indexAction()
    {
        View::render('Home/index.php', [
            'name' => 'Karl',
            'colors' => ['red', 'blue', 'green']
        ]);
    }
}
