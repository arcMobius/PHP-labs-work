<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактирование задачи</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<?php include __DIR__ . '/../header.php'; ?>

<main>
    <section class="form-block">
        <p>
            <a class="back-link" href="/tasks/<?= $task->getId() ?>">Вернуться к задаче</a>
        </p>

        <h2>Редактирование задачи</h2>

        <?php if ($message !== ''): ?>
            <p class="error-message">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="post">
            <label for="title">Название задачи:</label>
            <input
                type="text"
                id="title"
                name="title"
                value="<?= htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8') ?>"
            >

            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="8"><?= htmlspecialchars($task->getDescription(), ENT_QUOTES, 'UTF-8') ?></textarea>

            <label for="status">Статус:</label>
            <select id="status" name="status">
                <option value="new" <?= $task->getStatus() === 'new' ? 'selected' : '' ?>>Новая</option>
                <option value="in_progress" <?= $task->getStatus() === 'in_progress' ? 'selected' : '' ?>>В работе</option>
                <option value="done" <?= $task->getStatus() === 'done' ? 'selected' : '' ?>>Выполнена</option>
            </select>

            <label for="priority">Приоритет:</label>
            <select id="priority" name="priority">
                <option value="low" <?= $task->getPriority() === 'low' ? 'selected' : '' ?>>Низкий</option>
                <option value="medium" <?= $task->getPriority() === 'medium' ? 'selected' : '' ?>>Средний</option>
                <option value="high" <?= $task->getPriority() === 'high' ? 'selected' : '' ?>>Высокий</option>
            </select>

            <label for="deadline">Срок выполнения:</label>
            <input
                type="date"
                id="deadline"
                name="deadline"
                value="<?= htmlspecialchars((string) $task->getDeadline(), ENT_QUOTES, 'UTF-8') ?>"
            >

            <button type="submit">Сохранить</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>