<?php include __DIR__ . '/../header.php'; ?>

<?php foreach ($articles as $article): ?>
    <h2>
        <a href="/articles/<?= $article->getId() ?>">
            <?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>
        </a>
    </h2>

    <p><?= htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8') ?></p>

    <hr>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>