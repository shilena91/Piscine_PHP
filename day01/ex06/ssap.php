#!/usr/bin/php
<?php

/*
** This exercise will let you mix the previous two exercises.
** Your program must display all the words contained in all of the arguments, sorted.
*/

if ($argc < 2) {
    return;
}
function ft_split($var) {
    $arr = explode(' ', $var);
    $arr = array_filter($arr, function($x) {
        return $x !== '';
    });
    sort($arr);
    return $arr;
}

$i = 1;
$res = [];
while ($i < $argc) {
    $res = array_merge(ft_split($argv[$i]), $res);
    $i++;
}
sort($res);
$len = count($res);
$i = 0;
while ($i < $len) {
    echo $res[$i] . "\n";
    $i++;
}
