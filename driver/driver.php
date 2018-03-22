<?php
require __DIR__.'/../vendor/autoload.php';

use function FN\FOUNDATION\curry;


function go($a,$b,$c){
    return join("*",func_get_args());
}

$go = curry('go');
$goa = $go('a');
$gob = $goa('b');
$result  = $gob('c');
print_r($result);
