#!/usr/bin/php
<?php

/*
** This very basic program displays its command line arguments in the order it received them.
** The name of the program must not be displayed.
*/

$i = 1;
while ($i < $argc) {
    echo $argv[$i] . "\n";
    $i++;
}
