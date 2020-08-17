#!/usr/bin/php
<?php

/*
** Create the ft_split function. It will take a string as an argument,
** and will return a sorted array with the different words,
** initially separated by one or more spaces in the original string.
*/

function ft_split($var) {
    $arr = explode(' ', $var);
    $arr = array_filter($arr, function($x) {
        return $x !== '';
    });
    sort($arr);
    return $arr;
}
