<?php require dirname(__DIR__) . '/header.php'; ?>

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
    
<?php require dirname(__DIR__) . '/footer.php'; ?>