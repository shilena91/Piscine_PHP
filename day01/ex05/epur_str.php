#!/usr/bin/php
<?php

/*
** This program takes one unique argument and removes all the spaces at the beginning and at the end of the string.
** It should also reduce the spaces between each word to one single space.
** There will be only spaces, no tabulations or anything.
*/

if ($argc < 2) {
    return;
}
$arr = explode(' ', $argv[1]);
$arr = array_filter($arr, function($x) {
    return $x !== '';
});
$str = implode(' ', $arr) . "\n";
echo $str;
