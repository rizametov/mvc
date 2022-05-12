<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
</head>
<body>
    <h1>Posts list</h1>
    <hr>

    <?php foreach($posts as $post): ?>
            <ul>
                <li><?php echo 'Id: ', $post['id']; ?></li>
                <li><?php echo 'Title: ', $post['title']; ?></li>
                <li><?php echo 'Author: ', $post['author']; ?></li>
            </ul>
            <hr>
        <?php endforeach; ?>
    
</body>
</html>