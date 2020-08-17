#!/usr/bin/php
<?php

/*
** Your program will take a string as argument, and will place the first word
** (space separated portion of the string) at the last position.
** The string must then be displayed with only one space between each word.
*/

if ($argc < 2) {
    return;
}

$arr = explode(' ', $argv[1]);
$arr = array_filter($arr, function($x) {
    return $x !== '';
});
array_push($arr, array_shift($arr));
$str = implode(' ', $arr);
echo $str . "\n";
