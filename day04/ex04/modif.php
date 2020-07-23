<?php

$user = $_POST['login'] ?? '';
$pass_old = $_POST['oldpw'] ?? '';
$pass_new = $_POST['newpw'] ?? '';
$salt = $_POST['submit'] ?? '';

if (
    $user === ''
    || $pass_old === ''
    || $pass_new === ''
    || $salt === ''
    || $salt !== 'OK'
) {
    echo 'ERROR' . "\n";
    return;
}

$pass_old = hash('sha512', $pass_old);
$pass_new = hash('sha512', $pass_new);

$path = '../private';
$file = $path . '/passwd';

if (!file_exists(($file))) {
    echo 'ERROR' . "\n";
    return;
}

$data = file_get_contents($file);
$user_data = unserialize($data);

if (!$user_data[$user] || $user_data[$user]['passwd'] !== $pass_old) {
    echo 'ERROR' . "\n";
    return;
}

$user_data[$user] = [
    'login' => $user,
    'passwd' => $pass_new
];

$data = serialize($user_data);
file_put_contents($file, $data);

header('Location: index.html');
echo 'OK' . "\n";
