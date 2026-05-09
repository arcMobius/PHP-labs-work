<?php

interface CalculateSquare
{
    public function calculateSquare(): float;
}

class Square implements CalculateSquare
{
    private float $side;

    public function __construct(float $side)
    {
        $this->side = $side;
    }

    public function calculateSquare(): float
    {
        return $this->side * $this->side;
    }
}

class Circle implements CalculateSquare
{
    private float $radius;

    public function __construct(float $radius)
    {
        $this->radius = $radius;
    }

    public function calculateSquare(): float
    {
        return pi() * $this->radius * $this->radius;
    }
}

class Rectangle implements CalculateSquare
{
    private float $width;
    private float $height;

    public function __construct(float $width, float $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function calculateSquare(): float
    {
        return $this->width * $this->height;
    }
}

class User
{
    private string $name;

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}

$objects = [
    new Square(5),
    new Circle(3),
    new Rectangle(4, 6),
    new User('Иван'),
];

echo '<pre>';

foreach ($objects as $object) {
    $className = get_class($object);

    if ($object instanceof CalculateSquare) {
        echo 'Объект класса ' . $className . ' реализует интерфейс CalculateSquare.' . PHP_EOL;
        echo 'Площадь объекта класса ' . $className . ': ' . round($object->calculateSquare(), 2) . PHP_EOL;
    } else {
        echo 'Объект класса ' . $className . ' не реализует интерфейс CalculateSquare.' . PHP_EOL;
    }

    echo PHP_EOL;
}

echo '</pre>';