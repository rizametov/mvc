<?php declare(strict_types=1);

namespace App\Controllers\Admin;

class User extends \Core\Controller
{
    public function indexAction()
    {
        echo htmlentities(print_r($this->routeParams, true));
    }

    public function editAction()
    {
        echo htmlentities(print_r($this->routeParams, true));
    }

    protected function before()
    {
        echo '(before)';
    }

    protected function after()
    {
        echo '(after)';
    }
}
