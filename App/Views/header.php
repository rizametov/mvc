<?php

use App\Flash;
use App\Auth;

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title>php-mvc</title>
</head>
<body>

<?php foreach (Flash::get() as $item): ?>
    <div class="alert alert-<?= $item['type']?>"><?= $item['message'] ?></div>
<?php endforeach; ?>

<?php if (null !== ($user = Auth::getUser())): ?>
    <div>Hello <?php echo $user->name; ?></div>
    <hr>
    <div><a href="/login/logout">Logout</a></div>
    <hr>
    <div><a href="/books/index">Books</a></div>
    <hr>
    <div><a href="/posts/index">Posts</a></div>
<?php else: ?>
    <div><a href="/signup/index">Sign Up</a> or <a href="/login/index">Log In</a></div>
    <hr>
    <div><a href="/posts/index">Posts</a></div>
<?php endif; ?>
    
