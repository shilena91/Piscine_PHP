#!/usr/bin/php
<?php

if ($argc < 2)
    return;

if (!file_exists($argv[1]))
    return;

function enlarge_title_1($match) {
    return 'title="' . strtoupper($match[1]) . '"';
}

function enlarge_title_2($match) {
    return 'title="' . strtoupper($match[1]);
}

function enlarge_non_tag($match) {
    return strtoupper($match[1]) . $match[2] . strtoupper($match[3]);
}

$data = file_get_contents($argv[1]);
$data = preg_replace_callback('/(<a.*?>)([\s\S]*?)(<\/a>)/im', function ($match) {

}, $data);
