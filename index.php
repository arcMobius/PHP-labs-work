<?php

    date_default_timezone_set('Europe/Moscow'); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ЛР 1: Исправленная версия</title>
    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f0f2f5;
        }

        header {
            display: grid;
            grid-template-columns: 1fr auto 1fr;
            align-items: center;
            padding: 20px 40px;
            background-color: #ffffff;
            border-bottom: 4px solid #0054b2;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }


        .header-left img {
            display: block;
            max-width: 250px; 
            height: auto;     
        }

        header h1 {
            font-size: 1.6rem;
            color: #0054b2;
            text-align: center;
            margin: 0;
        }

        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .card {
            background: white;
            padding: 50px;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            text-align: center;
        }

        .time-display {
            font-size: 3.5rem;
            font-weight: 800;
            color: #333;
            letter-spacing: -1px;
            margin: 10px 0;
        }

        footer {
            background-color: #1a252f;
            color: white;
            padding: 25px;
            text-align: center;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 3px;
        }
    </style>
</head>
<body>

<header>
    <div class="header-left">
        <img src="logo.png" alt="Логотип МосПолитеха">
    </div>
    <h1>Домашняя работа: Hello, World!</h1>
    <div class="header-right"></div>
</header>

<main>
    <div class="card">
        <h2>Привет, мир!</h2>
        <p>Московское время (сервер):</p>
        <div class="time-display"><?php echo date("H:i:s"); ?></div>
        <p style="color: #666;"><?php echo date("d.m.Y"); ?></p>
        
        <hr style="border: 0; border-top: 1px dashed #ccc; margin: 30px 0;">
        
        <div style="font-size: 1.2rem;">
            <?php
                $hour = (int)date("H");
                if ($hour >= 5 && $hour < 12) echo "🌅 Доброе утро!";
                elseif ($hour >= 12 && $hour < 18) echo "🏙️ Добрый день!";
                elseif ($hour >= 18 && $hour < 23) echo "🌆 Добрый вечер!";
                else echo "🌌 Доброй ночи!";
            ?>
        </div>
    </div>
</main>

<footer>
    Задание для самостоятельной работы
</footer>

</body>
</html>