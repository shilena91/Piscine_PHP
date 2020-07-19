#!/usr/bin/php
<?php

if (argc != 4) {
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
