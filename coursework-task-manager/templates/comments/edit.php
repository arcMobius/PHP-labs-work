<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование комментария</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<?php include __DIR__ . '/../header.php'; ?>

<main>
    <section class="form-block">
        <p>
            <a class="back-link" href="/tasks/<?= $comment->getTaskId() ?>">Вернуться к задаче</a>
        </p>

        <h2>Редактирование комментария</h2>

        <?php if ($message !== ''): ?>
            <p class="error-message">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="post">
            <label for="author_id">Автор:</label>
            <select id="author_id" name="author_id">
                <?php foreach ($users as $user): ?>
                    <option
                        value="<?= $user->getId() ?>"
                        <?= $comment->getAuthorId() === $user->getId() ? 'selected' : '' ?>
                    >
                        <?= htmlspecialchars($user->getNickname(), ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="text">Текст комментария:</label>
            <textarea id="text" name="text" rows="7"><?= htmlspecialchars($comment->getText(), ENT_QUOTES, 'UTF-8') ?></textarea>

            <button type="submit">Сохранить комментарий</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>