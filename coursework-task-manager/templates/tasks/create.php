<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Создание задачи</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<?php include __DIR__ . '/../header.php'; ?>

<main>
    <section class="form-block">
        <p>
            <a class="back-link" href="/">Вернуться к списку задач</a>
        </p>

        <h2>Создание новой задачи</h2>

        <?php if ($message !== ''): ?>
            <p class="error-message">
                <?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?>
            </p>
        <?php endif; ?>

        <form method="post">
            <label for="author_id">Автор:</label>
            <select id="author_id" name="author_id">
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user->getId() ?>">
                        <?= htmlspecialchars($user->getNickname(), ENT_QUOTES, 'UTF-8') ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <label for="title">Название задачи:</label>
            <input type="text" id="title" name="title">

            <label for="description">Описание:</label>
            <textarea id="description" name="description" rows="8"></textarea>

            <label for="status">Статус:</label>
            <select id="status" name="status">
                <option value="new">Новая</option>
                <option value="in_progress">В работе</option>
                <option value="done">Выполнена</option>
            </select>

            <label for="priority">Приоритет:</label>
            <select id="priority" name="priority">
                <option value="low">Низкий</option>
                <option value="medium" selected>Средний</option>
                <option value="high">Высокий</option>
            </select>

            <label for="deadline">Срок выполнения:</label>
            <input type="date" id="deadline" name="deadline">

            <button type="submit">Создать задачу</button>
        </form>
    </section>
</main>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>