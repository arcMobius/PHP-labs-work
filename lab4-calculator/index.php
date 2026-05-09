<?php
function calculatorAdd(float $a, float $b): float
{
    return $a + $b;
}

function calculatorSubtract(float $a, float $b): float
{
    return $a - $b;
}

function calculatorMultiply(float $a, float $b): float
{
    return $a * $b;
}

function calculatorDivide(float $a, float $b): float
{
    if ($b == 0) {
        throw new Exception('Ошибка: деление на ноль.');
    }

    return $a / $b;
}

function calculatorPower(float $a, float $b): float
{
    return $a ** $b;
}

function calculatorSqrt(float $a): float
{
    if ($a < 0) {
        throw new Exception('Ошибка: нельзя извлечь корень из отрицательного числа.');
    }

    return sqrt($a);
}

function calculatorFactorial(float $number): float
{
    if ($number < 0 || floor($number) != $number) {
        throw new Exception('Ошибка: факториал можно вычислить только для целого неотрицательного числа.');
    }

    if ($number > 170) {
        throw new Exception('Ошибка: слишком большое число для факториала.');
    }

    if ($number <= 1) {
        return 1;
    }

    return $number * calculatorFactorial($number - 1);
}

function formatNumber(float $number): string
{
    if (is_infinite($number) || is_nan($number)) {
        return 'Ошибка вычисления';
    }

    if ($number == (int)$number) {
        return (string)(int)$number;
    }

    return rtrim(rtrim(number_format($number, 10, '.', ''), '0'), '.');
}

class ExpressionParser
{
    private string $expression;
    private int $position = 0;

    public function __construct(string $expression)
    {
        $this->expression = str_replace(' ', '', strtolower($expression));
    }

    public function parse(): float
    {
        if ($this->expression === '') {
            throw new Exception('Введите выражение.');
        }

        $result = $this->parseExpression();

        if ($this->position < strlen($this->expression)) {
            throw new Exception('Ошибка: выражение записано некорректно.');
        }

        return $result;
    }

    private function parseExpression(): float
    {
        $result = $this->parseTerm();

        while ($this->position < strlen($this->expression)) {
            $operator = $this->expression[$this->position];

            if ($operator !== '+' && $operator !== '-') {
                break;
            }

            $this->position++;
            $nextNumber = $this->parseTerm();

            if ($operator === '+') {
                $result = calculatorAdd($result, $nextNumber);
            } else {
                $result = calculatorSubtract($result, $nextNumber);
            }
        }

        return $result;
    }

    private function parseTerm(): float
    {
        $result = $this->parsePower();

        while ($this->position < strlen($this->expression)) {
            $operator = $this->expression[$this->position];

            if ($operator !== '*' && $operator !== '/') {
                break;
            }

            $this->position++;
            $nextNumber = $this->parsePower();

            if ($operator === '*') {
                $result = calculatorMultiply($result, $nextNumber);
            } else {
                $result = calculatorDivide($result, $nextNumber);
            }
        }

        return $result;
    }

    private function parsePower(): float
    {
        $result = $this->parseUnary();

        if ($this->position < strlen($this->expression) && $this->expression[$this->position] === '^') {
            $this->position++;
            $degree = $this->parsePower();
            $result = calculatorPower($result, $degree);
        }

        return $result;
    }

    private function parseUnary(): float
    {
        if ($this->position < strlen($this->expression) && $this->expression[$this->position] === '+') {
            $this->position++;
            return $this->parseUnary();
        }

        if ($this->position < strlen($this->expression) && $this->expression[$this->position] === '-') {
            $this->position++;
            return -$this->parseUnary();
        }

        return $this->parseFactorial();
    }

    private function parseFactorial(): float
    {
        $result = $this->parsePrimary();

        while ($this->position < strlen($this->expression) && $this->expression[$this->position] === '!') {
            $this->position++;
            $result = calculatorFactorial($result);
        }

        return $result;
    }

    private function parsePrimary(): float
    {
        if ($this->startsWith('sqrt')) {
            $this->position += 4;

            if (!$this->match('(')) {
                throw new Exception('Ошибка: после sqrt должна быть открывающая скобка.');
            }

            $result = $this->parseExpression();

            if (!$this->match(')')) {
                throw new Exception('Ошибка: после аргумента sqrt должна быть закрывающая скобка.');
            }

            return calculatorSqrt($result);
        }

        if ($this->startsWith('pi')) {
            $this->position += 2;
            return pi();
        }

        if ($this->startsWith('e')) {
            $this->position++;
            return exp(1);
        }

        if ($this->match('(')) {
            $result = $this->parseExpression();

            if (!$this->match(')')) {
                throw new Exception('Ошибка: не закрыта скобка.');
            }

            return $result;
        }

        return $this->parseNumber();
    }

    private function parseNumber(): float
    {
        $start = $this->position;
        $hasDot = false;

        while ($this->position < strlen($this->expression)) {
            $char = $this->expression[$this->position];

            if ($char === '.') {
                if ($hasDot) {
                    break;
                }

                $hasDot = true;
                $this->position++;
                continue;
            }

            if (!ctype_digit($char)) {
                break;
            }

            $this->position++;
        }

        if ($start === $this->position) {
            throw new Exception('Ошибка: ожидалось число.');
        }

        return (float)substr($this->expression, $start, $this->position - $start);
    }

    private function match(string $char): bool
    {
        if ($this->position < strlen($this->expression) && $this->expression[$this->position] === $char) {
            $this->position++;
            return true;
        }

        return false;
    }

    private function startsWith(string $text): bool
    {
        return substr($this->expression, $this->position, strlen($text)) === $text;
    }
}

$expression = $_GET['expression'] ?? '';
$result = '';
$error = '';

if ($expression !== '') {
    try {
        $parser = new ExpressionParser($expression);
        $result = formatNumber($parser->parse());
    } catch (Exception $exception) {
        $error = $exception->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Calculator</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="logo-block">
        <img src="logo.png" alt="Логотип Московского Политеха">
    </div>

    <h1>Calculator</h1>
</header>

<main>
    <section class="card">
        <h2>Калькулятор</h2>

        <form method="get" id="calculator-form">
            <input
                type="text"
                id="display"
                name="expression"
                value="<?= htmlspecialchars($expression) ?>"
                placeholder="Введите выражение"
                autocomplete="off"
            >

            <div class="result-block">
                <?php if ($error !== ''): ?>
                    <p class="error"><?= htmlspecialchars($error) ?></p>
                <?php elseif ($result !== ''): ?>
                    <p><strong>Результат:</strong> <?= htmlspecialchars($result) ?></p>
                <?php else: ?>
                    <p>Результат появится после вычисления.</p>
                <?php endif; ?>
            </div>

            <div class="buttons">
                <button type="button" onclick="clearDisplay()">C</button>
                <button type="button" onclick="appendToDisplay('(')">(</button>
                <button type="button" onclick="appendToDisplay(')')">)</button>
                <button type="button" onclick="backspace()">⌫</button>

                <button type="button" onclick="appendToDisplay('7')">7</button>
                <button type="button" onclick="appendToDisplay('8')">8</button>
                <button type="button" onclick="appendToDisplay('9')">9</button>
                <button type="button" onclick="appendToDisplay('/')">/</button>

                <button type="button" onclick="appendToDisplay('4')">4</button>
                <button type="button" onclick="appendToDisplay('5')">5</button>
                <button type="button" onclick="appendToDisplay('6')">6</button>
                <button type="button" onclick="appendToDisplay('*')">*</button>

                <button type="button" onclick="appendToDisplay('1')">1</button>
                <button type="button" onclick="appendToDisplay('2')">2</button>
                <button type="button" onclick="appendToDisplay('3')">3</button>
                <button type="button" onclick="appendToDisplay('-')">-</button>

                <button type="button" onclick="appendToDisplay('0')">0</button>
                <button type="button" onclick="appendToDisplay('.')">.</button>
                <button type="button" onclick="appendToDisplay('!')">!</button>
                <button type="button" onclick="appendToDisplay('+')">+</button>

                <button type="button" onclick="appendToDisplay('sqrt(')">√</button>
                <button type="button" onclick="appendToDisplay('^')">xʸ</button>
                <button type="button" onclick="appendToDisplay('pi')">π</button>
                <button type="button" onclick="appendToDisplay('e')">e</button>

                <button type="submit" class="equal">=</button>
            </div>
        </form>

        <div class="help">
            <p><strong>Примеры:</strong></p>
            <p>2+3*4</p>
            <p>(10-3)*2</p>
            <p>sqrt(25)</p>
            <p>5!</p>
            <p>2^3</p>
            <p>pi*2</p>
        </div>
    </section>
</main>

<footer>
    <p>Задание выполнено самостоятельно. Лабораторная работа №4.</p>
</footer>

<script>
    const display = document.getElementById('display');

    function appendToDisplay(value) {
        display.value += value;
        display.focus();
    }

    function clearDisplay() {
        display.value = '';
        display.focus();
    }

    function backspace() {
        display.value = display.value.slice(0, -1);
        display.focus();
    }
</script>

</body>
</html>