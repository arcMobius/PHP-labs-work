<?php include __DIR__ . '/../header.php'; ?>

<h1><?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?></h1>

<p><?= htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8') ?></p>

<?php if ($author !== null): ?>
    <p><strong>Автор:</strong> <?= htmlspecialchars($author->getNickname(), ENT_QUOTES, 'UTF-8') ?></p>
<?php else: ?>
    <p><strong>Автор:</strong> не найден</p>
<?php endif; ?>

<p>
    <a href="/article/<?= $article->getId() ?>/edit">Редактировать статью</a>
</p>

<?php include __DIR__ . '/../footer.php'; ?>