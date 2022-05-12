<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Books</title>
</head>
<body>
    <h1>Books list</h1>
    <hr>

    <?php foreach($books as $book): ?>
            <ul>
                <li><?php echo 'Id: ', $book['id']; ?></li>
                <li><?php echo 'Name: ', $book['name']; ?></li>
                <li><?php echo 'Author: ', $book['author']; ?></li>
            </ul>
            <hr>
        <?php endforeach; ?>
    
</body>
</html>