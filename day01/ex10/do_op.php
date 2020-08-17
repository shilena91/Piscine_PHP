#!/usr/bin/php
<?php

/*
** This PHP program will take 3 arguments. The first and third ones are numbers.
** The second is an arithmetic operation amongst : +, -, *, /, %.
** You need to make this operation and display the result.
** The program does not need to manage errors, except the number of arguments given.
** There can be spaces and tabulations in all of the arguments.
*/

if ($argc != 4) {
    echo 'Incorrect Parameter' . "\n";
    return;
}

$op = trim($argv[2]);

switch ($op) {
    case '+':
        echo $argv[1] + $argv[3];
        break;
    case '-':
        echo $argv[1] - $argv[3];
        break;
    case '*':
        echo $argv[1] * $argv[3];
        break;
    case '/':
        echo $argv[1] / $argv[3];
        break;
    case '%':
        echo $argv[1] % $argv[3];
        break;
}
echo "\n";
