<?php
error_reporting(E_ALL | E_STRICT);

$stRoot = realpath(dirname(dirname(__DIR__)));

require_once $stRoot . '/vendor/autoload.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->registerNamespaces(array(
    'Stalxed\\System'     => $stRoot . '/library/',
    'StalxedTest\\System' => $stRoot . '/tests/unit/'
));
$loader->register();

$random = Random::getInstance();

$actual_digit = $random->getDigit(1, 10);

$actual_shuffle = array(1, 2, 3, 4, 5);
$actual_shuffle = $random->shuffle($actual_shuffle);
?>
<html>
    <head>
        <title>Функциональное тестирование класса System_Random.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <h1>Функциональное тестирование класса System_Random.</h1>
        
        <h2>Функция getDigit:</h2>
        <p><b>Ожидаемое значение:</b> случайное число от 1 до 10.</p>
        <p><b>Реальное значение:</b> <?php echo $actual_digit; ?>.</p>
        
        <h2>Функция shuffle:</h2>
        <p><b>Ожидаемое значение:</b> массив со значениями 1, 2, 3, 4, 5 в случайном порядке.</p>
        <p><b>Реальное значение:</b> <?php echo implode(', ', $actual_shuffle); ?>.</p>
    </body>
</html>