#!/usr/bin/php
<?php

/*
** Your program will take as first argument a string containing a key.
** It will then search amongst an unlimited number of 'key:value' pairs the value corresponding to the given key and display it.
*/

if ($argc < 3) {
    return;
}

$data = [];
$i = 2;
while ($i < $argc) {
    $parts = explode(':', $argv[$i]);
    if (count($parts) != 2) {
        $i++;
        continue;
    }
    $data[$parts[0]] = $parts[1];
    $i++;
}

if (array_key_exists($argv[1], $data)) {
    echo $data[$argv[1]] . "\n";
}
