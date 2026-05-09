<?php

class Cat
{
    private string $name;
    private string $color;

    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    public function sayHello(): string
    {
        return 'Мяу! Меня зовут ' . $this->name . '. Мой цвет: ' . $this->color . '.';
    }

    public function getColor(): string
    {
        return $this->color;
    }
}

$cat = new Cat('Барсик', 'серый');

echo '<pre>';
echo $cat->sayHello() . PHP_EOL;
echo 'Цвет кошки через геттер: ' . $cat->getColor() . PHP_EOL;
echo '</pre>';