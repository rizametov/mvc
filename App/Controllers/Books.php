<?php declare(strict_types=1);

namespace App\Controllers;

use Core\View;
use App\Models\Book;
use App\Controllers\Authenticated;

class Books extends Authenticated
{
    public function indexAction(): void
    {
        View::render('Book/index.php', ['books' => Book::all()]);
    }
}
