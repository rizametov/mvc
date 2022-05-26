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