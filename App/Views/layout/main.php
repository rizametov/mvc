<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/style.css">
    <title><?= $title ?? 'Home' ?></title>
</head>
<body>

<?php foreach (\App\Flash::get() as $item): ?>
    <div class="alert alert-<?= $item['type'] ?>"><?= $item['message'] ?></div>
<?php endforeach; ?>

<a href="/">Home</a>&nbsp
<a href="/posts/index">Posts</a>&nbsp
<a href="/books/index">Books</a>&nbsp

<hr>

<?= $content ?>

<script src="/js/main.js"></script>
</body>
</html>