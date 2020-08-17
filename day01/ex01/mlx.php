#!/usr/bin/php
<?php

/*
** create a program that can display 1000 times the letter X, a newline,
** and with the constraint that it cannot go over 100 chars.
*/

$i = 0;
while ($i < 1000) {
    echo 'X';
    $i++;
}
echo "\n";
