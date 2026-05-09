<?php
$headers = @get_headers('http://httpbin.org/post');
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Feedback Form — Headers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo-block">
        <img src="logo.png" alt="Логотип Московского Политеха">
    </div>

    <h1>Feedback Form</h1>
</header>

<main>
    <section class="form-block">
        <h2>Результат работы функции get_headers()</h2>

        <textarea rows="14" readonly><?php
if ($headers === false) {
    echo 'Не удалось получить заголовки.';
} else {
    echo htmlspecialchars(implode("\n", $headers));
}
?></textarea>

        <a class="page-link" href="index.php">Вернуться к форме</a>
    </section>
</main>

<footer>
    <p>Работа выполнена самостоятельно. Лабораторная работа №2.</p>
</footer>

</body>
</html>