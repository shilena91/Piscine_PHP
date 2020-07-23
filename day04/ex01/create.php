<?php

$user = $_POST['login'] ?? '';
$pass = $_POST['passwd'] ?? '';
$salt = $_POST['submit'] ?? '';

if ($user === '' || $pass === '' || $salt === '' || $salt !== 'OK') {
    echo 'ERROR' . "\n";
    return;
}

$pass = hash('sha512', $pass);

$path = '../private';
$file = $path . '/passwd';

if(!file_exists($path))
    mkdir($path);

$user_data = [];

if (file_exists($file)) {
    $data = file_get_contents($file);
    $user_data = unserialize($data);
}

if ($user_data[$user]) {
    echo 'ERROR' . "\n";
    return;
}

$user_data[$user] = [
    'login' => $user,
    'passwd' => $pass
];

$data = serialize($user_data);
file_put_contents($file, $data);

echo 'OK' . "\n";
