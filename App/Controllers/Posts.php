<?php declare(strict_types=1);

namespace App\Controllers;

use Core\Controller;
use App\Models\Post;

class Posts extends Controller
{
    public function indexAction(): void
    {
        $this->render('Post/index', [
            'title' => 'Posts List', 
            'posts' => Post::all()
        ]);
    }
}
