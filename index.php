<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            background: linear-gradient(135deg, #000428, #004e92); /* Gradient background */
            color: #fff; /* White text */
            font-family: 'Roboto', sans-serif; /* Modern font */
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh; /* Full height */
            overflow: hidden; /* Hide overflow */
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8); /* Semi-transparent background */
            padding: 30px; /* Larger padding */
            border: 2px solid lightblue;
            box-shadow: 0 0 75px rgba(0, 255, 255, 0.5);
            border-radius: 30px; /* More rounded corners */
            text-align: center; /* Center text */
            color:#fff;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
        class Person
        {
            public $name;
            public $age;
            function __construct($name, $age)
            {
                $this->name = $name;
                $this->age = $age;
            }
            function show_serson() {
                echo "The person object $this->name is $this->age years old is created!<br>";
            }

            function __destruct()
            {
                echo "The person object $this->name is $this->age years old is clear!<br>";
            }
        }
         
        $person = new Person("Jane",23);
        $person->show_serson();

        class Collection
        {
            private array $numbers; 
            private int $size; // Добавляем типизацию для $size

            // Конструктор класса с типизированным аргументом $size
            public function __construct(int $size = 10) {
                $this->size = $size;
                $this->numbers = array_fill(0, $size, 0); // Инициализируем массив
            }
        
            // Деструктор класса
            public function __destruct() {
                echo "<br>The collection object is cleared!<br>";
            }
            function set_random_num($number){
                for ($i=0; $i < $this->size; $i++) { 
                    $this->numbers[$i] = rand(0,$number);
                }
            }
            function show_numbers($message) {
                echo $message."<br>";
                for ($i=0; $i < $this->size; $i++) {
                    echo $this->numbers[$i]." ";
                }
                echo "</br>";
            }
            function rearrange_numbers() {
                shuffle($this->numbers);
            }
            function find_count_numbers() {
                $valuesCount = array_count_values($this->numbers);
                $duplicates = array_filter($valuesCount, function($count) {
                    return $count > 1; // Фильтруем только те элементы, которые встречаются более одного раза
                });
                print_r($duplicates);
            }
        }

        $numbers = new Collection(10);
        $numbers->set_random_num(10);
        $numbers->show_numbers("The numbers in the collaction object are:");
        $numbers->rearrange_numbers();
        $numbers->show_numbers("The shuffle numbers in the collaction object are:");
        $numbers->show_numbers("The count repeat numbers in the collaction object are:");
        $numbers->find_count_numbers();
        
        class FixedStringArray
{
    private array $array;
    private int $size;

    public function __construct(int $size)
    {
        if ($size <= 0) {
            throw new InvalidArgumentException("Array size must be greater than zero.");
        }
        $this->size = $size;
        $this->array = array_fill(0, $size, '');
    }

    public function __destruct() {
        echo "<br>The FixedStringArray object is clear!";
    }

    // Проверка выхода за пределы массива
    private function checkIndex(int $index): void
    {
        if ($index < 0 || $index >= $this->size) {
            throw new OutOfBoundsException("Index $index is out of bounds [0, " . ($this->size - 1) . "].");
        }
    }

    // Получение элемента по индексу
    public function getElement(int $index): string
    {
        $this->checkIndex($index);
        return $this->array[$index];
    }

    // Установка элемента по индексу
    public function setElement(int $index, string $value): void
    {
        $this->checkIndex($index);
        $this->array[$index] = $value;
    }

    // Поэлементное сцепление двух массивов
    public static function concatenate(FixedStringArray $array1, FixedStringArray $array2): FixedStringArray
    {
        $minSize = min($array1->size, $array2->size);
        $newArray = new self($minSize);
        for ($i = 0; $i < $minSize; $i++) {
            $newArray->setElement($i, $array1->getElement($i) . $array2->getElement($i));
        }
        return $newArray;
    }

    // Слияние двух массивов с исключением повторяющихся элементов
    public static function merge(FixedStringArray $array1, FixedStringArray $array2): FixedStringArray
    {
        $mergedValues = array_unique(array_merge($array1->array, $array2->array));
        $mergedArray = new self(count($mergedValues));
        foreach ($mergedValues as $index => $value) {
            $mergedArray->setElement($index, $value);
        }
        return $mergedArray;
    }

    // Вывод элемента массива по индексу
    public function printElement(int $index): void
    {
        echo "Element at index $index: " . $this->getElement($index) ."] <br>";
    }

    // Вывод всего массива
    public function printArray(): void
    {
        echo "<br>Array contents: [ " . implode(", ", $this->array) ."] <br>";
    }
}
try {
    $array1 = new FixedStringArray(5);
    $array2 = new FixedStringArray(5);

    $array1->setElement(0, "Hello");
    $array1->setElement(1, "World");
    $array1->setElement(2, "PHP");
    $array1->setElement(3, "is");
    $array1->setElement(4, "Great");

    $array2->setElement(0, "Welcome");
    $array2->setElement(1, "to");
    $array2->setElement(2, "the");
    $array2->setElement(3, "World");
    $array2->setElement(4, "of PHP");

    $array1->printArray();
    $array2->printArray();

    $concatenatedArray = FixedStringArray::concatenate($array1, $array2);
    $concatenatedArray->printArray();

    $mergedArray = FixedStringArray::merge($array1, $array2);
    $mergedArray->printArray();

} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
    ?>
    </div>
</body>
</html>