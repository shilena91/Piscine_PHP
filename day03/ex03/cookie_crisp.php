<?php

/*
** Create a file cookie_crisp.php that will allow you to create, read and erase a cookie.
*/

$action = $_GET['action'];
$name = $_GET['name'];
$value = $_GET['value'];
$expires = time() + 3600;

switch ($action) {
    case 'set':
        setcookie($name, $value, $expires);
        return;
    case 'get':
        if (!$_COOKIE[$name])
            return;
        echo $_COOKIE[$name] . "\n";
        return;
    case 'del':
        setcookie($name, $value, 1);
        return;
}
