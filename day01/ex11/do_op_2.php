#!/usr/bin/php
<?php

/*
** This time, your program will receive only one argument.
** It will contain the whole calculation that needs to be done.
** It will always be under the format of number - operator - number.
** A new error message ``Syntax Error'' will now complete the prior message in case the syntax isn’t correct.
** There can be either zero or multiple spaces between the numbers and the operator. The expected result is the same.
*/

if ($argc != 2) {
    echo 'Incorrect Parameters' . "\n";
    return;
}

function display_error() {
    echo 'Syntax Error' . "\n";
}

function do_op($op, $oppos, $str) {
    $n1 = substr($str, 0, $oppos);
    $n2 = substr($str, $oppos + 1);

    if (!is_numeric($n1) || !is_numeric($n2))
        return false;
    
    switch ($op) {
        case '+':
            echo $n1 + $n2;
            break;
        case '-':
            echo $n1 - $n2;
            break;
        case '*':
            echo $n1 * $n2;
            break;
        case '/':
            echo $n1 / $n2;
            break;
        case '%':
            echo $n1 % $n2;
            break;
    }

    echo "\n";
    return true;
}

function find_op($op, $str) {
    $oppos = strpos($str, $op);
    if ($oppos === false) {
        return false;
    }
    if (do_op($op, $oppos, $str)) {
        return true;
    }
}

$arr = explode(' ', $argv[1]);
$arr = array_filter($arr, function($x) {
    return $x !== '';
});
$str = implode('', $arr);

if (
    find_op('+', $str)
    || find_op('-', $str)
    || find_op('*', $str)
    || find_op('/', $str)
    || find_op('%', $str)
) {
    return;
}
display_error();
