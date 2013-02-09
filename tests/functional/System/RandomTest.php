<?php
require_once dirname(__DIR__) . '/Bootstrap.php';

use Stalxed\System\Random;

$random = new Random();

$actualNumber = $random->generateNumber(1, 10);

$actualArray = array(1, 2, 3, 4, 5);
$actualArray = $random->shuffle($actualArray);
?>
<html>
    <head>
        <title>Functional testing of a class Stalxed\System\Random.</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <h1>Functional testing of a class Stalxed\System\Random.</h1>
        
        <h2>Function generateNumber:</h2>
        <p><b>Expected value:</b> random number from 1 to 10.</p>
        <p><b>Actual value:</b> <?php echo $actualNumber; ?>.</p>
        
        <h2>Function shuffle:</h2>
        <p><b>Expected value:</b> array with the values 1, 2, 3, 4, 5 in random order.</p>
        <p><b>Actual value:</b> <?php echo implode(', ', $actualArray); ?>.</p>
    </body>
</html>