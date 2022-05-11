<?php require dirname(__DIR__) . '/templates/header.php'; ?>

    <?php foreach ($posts as $post): ?>   
        <li><?php echo htmlentities($post['content']); ?></li>
    <?php endforeach; ?>

<?php require dirname(__DIR__) . '/templates/footer.php'; ?>