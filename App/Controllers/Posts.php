<?php declare(strict_types=1);

namespace App\Controllers;

class Posts extends \Core\Controller    
{
    public function indexAction()
    {
        echo 'Posts controller, action index';
    }

    public function edit()
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
