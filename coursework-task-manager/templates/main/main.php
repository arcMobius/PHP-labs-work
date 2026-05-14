<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Task Manager</title>
    <link rel="stylesheet" href="/styles/style.css">
</head>
<body>
<?php include __DIR__ . '/../header.php'; ?>

<main>
    <section class="content-block">
        <h2>Список задач курсового проекта</h2>

<p class="task-actions">
    <a href="/tasks/create">Создать новую задачу</a>
</p>
        
        <?php foreach ($tasks as $task): ?>
            <article class="task-card">
                <h3>
                    <a href="/tasks/<?= $task->getId() ?>">
                        <?= htmlspecialchars($task->getTitle(), ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </h3>

                <p class="task-description">
                    <?= nl2br(htmlspecialchars($task->getDescription(), ENT_QUOTES, 'UTF-8')) ?>
                </p>

                <p class="task-meta">
                    <strong>Статус:</strong>
                    <?= htmlspecialchars($task->getStatusLabel(), ENT_QUOTES, 'UTF-8') ?>
                    <br>
                    <strong>Приоритет:</strong>
                    <?= htmlspecialchars($task->getPriorityLabel(), ENT_QUOTES, 'UTF-8') ?>
                </p>
            </article>
        <?php endforeach; ?>
    </section>
</main>

<?php include __DIR__ . '/../footer.php'; ?>
</body>
</html>