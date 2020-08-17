#!/usr/bin/php
<?php

/*
** function that will return true or false according to whether
** the array passed as argument is sorted or not.
*/

function ft_is_sort($arr) {
    $save = $arr;
    sort($arr);
    $res = array_diff_assoc($arr, $save);
    if (count($res) > 0) {
        return 0;
    }
    return 1;
}
