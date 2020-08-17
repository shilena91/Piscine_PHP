#!/usr/bin/php
<?php

/*
** $> ./one_more_time.php "Mardi 12 Novembre 2013 12:02:21"
** 1384254141
** $> ./one_more_time.php "Mercreday 1stJuily 99"
** Wrong Format
** $> ./one_more_time.php
** $>
*/

$status = preg_match('/[\p{L}]+ [0-3][0-9] [\p{L}]+ [0-9]{4} [0-9]{2}:[0-9]{2}:[0-9]{2}/', $argv[1]);
if (!$status) {
    echo 'Wrong Format' . "\n";
    return;
}

setlocale(LC_TIME, 'fr_FR');
$date = strptime($argv[1], '%A %d %B %Y %H:%M:%S');

if (
    $date === false
    || $date['tm_year'] === false
    || $date['tm_yday'] === false
    || $date['tm_hour'] === false
    || $date['tm_min'] === false
    || $date['tm_sec'] === false
) {
    echo 'Wrong Format' . "\n";
    return;
}

$date = date_create_from_format(
    'Y z H:i:s',
    sprintf('%d %d %02d:%02d:%02d', $date['tm_year'] + 1900, $date['tm_yday'], $date['tm_hour'], $date['tm_min'], $date['tm_sec']),
    new DateTimeZone('Europe/Paris')
);

echo $date->getTimestamp() . "\n";
