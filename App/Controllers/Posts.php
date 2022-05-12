<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use Core\Controller;
use App\Models\Post;

class Posts extends Controller
{
    public function indexAction(): void
    {
        View::render('Post/index.php', ['posts' => Post::all()]);
    }
}
