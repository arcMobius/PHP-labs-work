<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Feedback Form</title>
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
        <h2>Форма обратной связи</h2>

        <form action="https://httpbin.org/post" method="post">
            <label for="username">Имя пользователя</label>
            <input type="text" id="username" name="username" required>

            <label for="email">E-mail пользователя</label>
            <input type="email" id="email" name="email" required>

            <label for="type">Тип обращения</label>
            <select id="type" name="type" required>
                <option value="">Выберите тип обращения</option>
                <option value="complaint">Жалоба</option>
                <option value="suggestion">Предложение</option>
                <option value="thanks">Благодарность</option>
            </select>

            <label for="message">Текст обращения</label>
            <textarea id="message" name="message" rows="6" required></textarea>

            <p class="answer-title">Вариант ответа</p>

            <label class="checkbox-label">
                <input type="checkbox" name="answer_sms" value="sms">
                SMS
            </label>

            <label class="checkbox-label">
                <input type="checkbox" name="answer_email" value="email">
                E-mail
            </label>

            <button type="submit">Отправить</button>
        </form>

        <a class="page-link" href="headers.php">Перейти на вторую страницу</a>
    </section>
</main>

<footer>
    <p>Задание для самостоятельно работы. Лабораторная работа №2.</p>
</footer>

</body>
</html>