<?php declare(strict_types=1);

namespace App\Controllers;

use App\Models\Book;
use App\Controllers\Authenticated;

class Books extends Authenticated
{
    public function indexAction(): void
    {
        $this->render('Book/index', [
            'title' => 'Books', 
            'books' => Book::all()
        ]);
    }
}
