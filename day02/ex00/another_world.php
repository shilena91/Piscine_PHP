#!/usr/bin/php
<?php

/*
** $> ./another_world.php "This   sentence   contains   spaces  and  some    tabulations"
This sentence contains spaces and some tabulations
** $> ./another_world.php
** $> ./another_world.php " This arg   is   used  " "  but  not  this   one"
** This arg is used
** $>
*/

if ($argc < 2) {
    return;
}

$str = preg_replace('/[ \t]+/', ' ', $argv[1]);
$str = trim($str);
echo $str . "\n";
