<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8') ?></title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<?php include __DIR__ . '/../header.php'; ?>

<main>
    <section class="content-block">
        <p>
            <a class="back-link" href="/">Вернуться к списку задач</a>
        </p>

        <h2><?= htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8') ?></h2>

        <p class="task-description">
            <?= nl2br(htmlspecialchars($task->getDescription(), ENT_QUOTES, 'UTF-8')) ?>
        </p>

        <p class="task-meta">
            <strong>Статус:</strong>
            <?= htmlspecialchars($task->getStatusLabel(), ENT_QUOTES, 'UTF-8') ?>
            <br>

            <strong>Приоритет:</strong>
            <?= htmlspecialchars($task->getPriorityLabel(), ENT_QUOTES, 'UTF-8') ?>
            <br>

            <?php if ($task->getDeadline() !== null): ?>
                <strong>Срок:</strong>
                <?= htmlspecialchars($task->getDeadline(), ENT_QUOTES, 'UTF-8') ?>
                <br>
            <?php endif; ?>

            <?php if ($author !== null): ?>
                <strong>Автор:</strong>
                <?= htmlspecialchars($author->getNickname(), ENT_QUOTES, 'UTF-8') ?>
            <?php else: ?>
                <strong>Автор:</strong> не найден
            <?php endif; ?>
        </p>

        <p class="task-actions">
            <a href="/tasks/<?= $task->getId() ?>/edit">Редактировать задачу</a>
        </p>

        <section class="comments-block">
            <h3>Комментарии</h3>

            <?php if (empty($comments)): ?>
                <p>К этой задаче пока нет комментариев.</p>
            <?php endif; ?>

            <?php foreach ($comments as $comment): ?>
                <?php $commentAuthor = $comment->getAuthor(); ?>

                <article class="comment" id="comment<?= $comment->getId() ?>">
                    <p class="comment-meta">
                        <strong>
                            <?= $commentAuthor !== null
                                ? htmlspecialchars($commentAuthor->getNickname(), ENT_QUOTES, 'UTF-8')
                                : 'Пользователь не найден'
                            ?>
                        </strong>

                        <br>

                        Дата публикации:
                        <?= htmlspecialchars($comment->getCreatedAt(), ENT_QUOTES, 'UTF-8') ?>
                    </p>

                    <p>
                        <?= nl2br(htmlspecialchars($comment->getText(), ENT_QUOTES, 'UTF-8')) ?>
                    </p>

                    <p>
                        <a href="/comments/<?= $comment->getId() ?>/edit">Редактировать</a>
                    </p>
                </article>
            <?php endforeach; ?>

            <h3>Добавить комментарий</h3>

            <form method="post" action="/tasks/<?= $task->getId() ?>/comments">
                <label for="author_id">Автор:</label>
                <select id="author_id" name="author_id">
                    <?php foreach ($users as $user): ?>
                        <option value="<?= $user->getId() ?>">
                            <?= htmlspecialchars($user->getNickname(), ENT_QUOTES, 'UTF-8') ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <label for="text">Текст комментария:</label>
                <textarea id="text" name="text" rows="5"></textarea>

                <button type="submit">Добавить комментарий</button>
            </form>
        </section>
    </section>
</main>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>