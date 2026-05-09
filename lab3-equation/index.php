<?php
$variant = 0;
$equation = 'X * 9 = 56';

function formatNumber(float $number): string
{
    if ($number == (int)$number) {
        return (string)(int)$number;
    }

    return rtrim(rtrim(number_format($number, 6, '.', ''), '0'), '.');
}

function solveEquation(string $equation): array
{
    $cleanEquation = str_replace([' ', ';'], '', strtoupper($equation));

    preg_match('/^([0-9.]+|X)([+\-*\/])([0-9.]+|X)=([0-9.]+)$/', $cleanEquation, $matches);

    if (empty($matches)) {
        return [
            'error' => 'Уравнение записано некорректно.'
        ];
    }

    $leftOperand = $matches[1];
    $operator = $matches[2];
    $rightOperand = $matches[3];
    $result = (float)$matches[4];

    $isXLeft = $leftOperand === 'X';
    $isXRight = $rightOperand === 'X';

    if (!$isXLeft && !$isXRight) {
        return [
            'error' => 'В уравнении не найдена переменная X.'
        ];
    }

    if ($isXLeft && $isXRight) {
        return [
            'error' => 'В уравнении должно быть только одно значение X.'
        ];
    }

    $leftNumber = $isXLeft ? null : (float)$leftOperand;
    $rightNumber = $isXRight ? null : (float)$rightOperand;

    switch ($operator) {
        case '+':
            $x = $isXLeft ? $result - $rightNumber : $result - $leftNumber;
            break;

        case '-':
            $x = $isXLeft ? $result + $rightNumber : $leftNumber - $result;
            break;

        case '*':
            $x = $isXLeft ? $result / $rightNumber : $result / $leftNumber;
            break;

        case '/':
            $x = $isXLeft ? $result * $rightNumber : $leftNumber / $result;
            break;

        default:
            return [
                'error' => 'Неизвестный оператор.'
            ];
    }

    $operatorNames = [
        '+' => 'сложение',
        '-' => 'вычитание',
        '*' => 'умножение',
        '/' => 'деление'
    ];

    return [
        'operator' => $operator,
        'operatorName' => $operatorNames[$operator],
        'position' => $isXLeft ? 'X находится слева от оператора' : 'X находится справа от оператора',
        'x' => $x
    ];
}

$solution = solveEquation($equation);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Equation</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo-block">
        <img src="logo.png" alt="Логотип Московского Политеха">
    </div>

    <h1>Equation</h1>
</header>

<main>
    <section class="card">
        <h2>Решение уравнения</h2>

        <div class="result">
            <p><strong>Последняя цифра номера студенческого:</strong> <?= $variant ?></p>
            <p><strong>Уравнение:</strong> <?= htmlspecialchars($equation) ?></p>

            <?php if (isset($solution['error'])): ?>
                <p class="error"><?= htmlspecialchars($solution['error']) ?></p>
            <?php else: ?>
                <p><strong>Оператор:</strong> <?= htmlspecialchars($solution['operator']) ?> — <?= htmlspecialchars($solution['operatorName']) ?></p>
                <p><strong>Расположение неизвестной переменной:</strong> <?= htmlspecialchars($solution['position']) ?></p>
                <p><strong>Решение:</strong> X = 56 / 9</p>
                <p><strong>Ответ:</strong> X = <?= formatNumber($solution['x']) ?></p>
            <?php endif; ?>
        </div>

        <h2>Блок-схема алгоритма</h2>

        <div class="scheme">
            <img src="flowchart.png" alt="flowchart">
        </div>
    </section>
</main>

<footer>
    <p>Задание выполнено самостоятельно. Лабораторная работа №3.</p>
</footer>

</body>
</html>