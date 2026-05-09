<?php include __DIR__ . '/../header.php'; ?>

<h1>Редактирование статьи</h1>

<?php if ($message !== ''): ?>
    <p><strong><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></strong></p>
<?php endif; ?>

<form method="post" action="/article/<?= $article->getId() ?>/edit">
    <p>
        <label for="name">Название статьи</label><br>
        <input
            type="text"
            id="name"
            name="name"
            value="<?= htmlspecialchars($article->getName(), ENT_QUOTES, 'UTF-8') ?>"
        >
    </p>

    <p>
        <label for="text">Текст статьи</label><br>
        <textarea id="text" name="text" rows="8" cols="70"><?= htmlspecialchars($article->getText(), ENT_QUOTES, 'UTF-8') ?></textarea>
    </p>

    <p>
        <button type="submit">Сохранить изменения</button>
    </p>
</form>

<p>
    <a href="/articles/<?= $article->getId() ?>">Вернуться к статье</a>
</p>

<?php include __DIR__ . '/../footer.php'; ?>