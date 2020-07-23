<?php

function auth($login, $passwd) {
    if ($login === '' || $passwd === '')
        return FALSE;

    $path = '../private';
    $file = $path . '/passwd';

    if (!file_exists($file))
        return FALSE;
    
    $data = file_get_contents($file);
    $user_data = unserialize($data);

    if (!$user_data[$login])
        return FALSE;
    
    $hash = hash('sha512', $passwd);
    if ($user_data[$login]['passwd'] !== $hash)
        return FALSE;
    
    return TRUE;
}
