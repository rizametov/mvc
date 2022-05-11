<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Post;
use Core\View;
use Core\Controller;

class Posts extends Controller    
{
    public function indexAction()
    {
        $posts = Post::all();

        View::render('Posts/index.php', ['posts' => $posts]);
    }

    public function edit()
    {
        echo htmlentities(print_r($this->routeParams, true));
    }
}
