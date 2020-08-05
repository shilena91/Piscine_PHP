<?php

session_start();
require_once('../model/user.php');

$functions = array('name', 'register', 'login', 'update');

function register(array $data) {
    $err = NULL;

    if (!isset($data['name']))
        $err[] = 'name';
    if (!isset($data['email']))
        $err[] = 'email';
    if (!isset($data['password']))
        $err[] = 'password';
    if (!isset($data['firstname']))
        $err[] = 'firstname';
    if (!isset($data['lastname']))
        $err[] = 'lastname';
    if ($err === NULL) {
        if (user_exist($data['name']) === NULL)
            return (create_user($data['name'], $data['email'], $data['password'], $data['firstname'], $data['lastname'], $data['address'], 0));
        else
            return (array('exist'));
    }
    else
        return $err;
}

function login(array $data) {
    $err = NULL;
    if (!isset($data['name']))
        $err[] = 'name';
    if (!isset($data['password']))
        $err[] = 'password';
    if ($err === NULL) {
        $data = get_user($data['name'], $data['password']);
        if ($data === NULL)
            return (array('notfound'));
        $_SESSION['login'] = $data['login'];
        return NULL;
    }
    else
        return ($err);
}

function update(array $data) {
    if (user_exist($_SESSION['login']))
        return (update_user($_SESSION['login'], $data['firstname'], $data['lastname'], $data['password'], $data['address']));
    else
        return (array('no exist'));
}

if ($_POST['from'] && in_array($_POST['from'], $functions)) {
    $err = $_POST['from']($_POST);
    if (!($err === TRUE || $err === NULL)) {
        $str_err = implode('&', $err);
        if ($_POST['error']) {
            header('Location: ../' . $_POST['error'] . '.php?' . $str_err);
            exit();
        }
        header('Location: ../' . $_POST['from'] . '.php?' . $str_err);
        exit();
    }
    header('Location: ../' . $_POST['success'] . '.php?');
}
?>
