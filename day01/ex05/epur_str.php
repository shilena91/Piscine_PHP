#!/usr/bin/php
<?php

if ($argc < 2) {
    return;
}
$arr = explode(' ', $argv[1]);
$arr = array_filter($arr, function($x) {
    return $x !== '';
});
$str = implode($arr, ' ') . "\n";
echo $str;
