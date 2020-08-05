<?php
require_once('mysqli.php');
require_once('hash.php');

function create_user(string $name, string $email, string $password, string $firstname, string $lastname, string $address, bool $isAdmin = false) {

    $db = connect_database();
    $err = array();
    if (strlen($name) > 45 || strlen($name) < 4)
        $err[] = 'name';
    if (filter_var($email, FILTER_VALIDATE_EMAIL) == FALSE)
        $err[] = 'email';
    if (strlen($password) < 6)
        $err[] = 'password';
    else {
        if ($isAdmin)
            $password = NULL;
        else
            $password = user_pass($password);
    }
    if (strlen($firstname) < 3 || strlen($firstname) > 45)
        $err[] = 'firstname';
    if (strlen($lastname) < 3 || strlen($lastname) > 45)
        $err[] = 'lastname';
    if (!empty($err))
        return ($err);
    $name = mysqli_real_escape_string($db, $name);
    $email = mysqli_real_escape_string($db, $email);
    $password = mysqli_real_escape_string($db, $password);
    $firstname = mysqli_real_escape_string($db, $firstname);
    $lastname = mysqli_real_escape_string($db, $lastname);
    $address = mysqli_real_escape_string($db, $address);
    $isAdmin = $isAdmin == false ? 0 : 1;
    $req = "INSERT INTO users (login, email, password, isAdmin, firstname, lastname, address)
            VALUES ('$name', '$email', '$password', '$isAdmin', '$firstname', '$lastname', '$address')";
    if (mysqli_query($db, $req) === TRUE)
        return TRUE;
    return (array('general'));
}

function user_exist($name) {
    $db = connect_database();

    $name = mysqli_real_escape_string($db, $name);
    $req = "SELECT * FROM users WHERE login = '$name'";
    $req = mysqli_query($db, $req);
    if (!$req)
        return NULL;
    return mysqli_fetch_assoc($req);
}

function get_user($name, $password) {
    $db = connect_database();

    $password = user_pass($password);
    $name = mysqli_real_escape_string($db, $name);
    $req = mysqli_query($db, "SELECT * FROM users WHERE login = '$name' AND password = '$password' AND isAdmin = 0");
    if (!$req)
        return NULL;
    return mysqli_fetch_assoc($req);
}

function update_user($name, string $firstname, string $lastname, string $password, string $address) {
    $err = NULL;
    $db = connect_database();

    if (strlen($firstname) < 4 || strlen($firstname) > 45)
			$err[] = 'firstname';
	if (strlen($lastname) < 4 || strlen($lastname) > 45)
		$err[] = 'lastname';
	if (strlen($password) < 7)
		$err[] = 'password';
	else
        $password = user_pass($password);
    
    if (!empty($err))
        return ($err);
    $name = mysqli_real_escape_string($db, $name);
	$firstname = mysqli_real_escape_string($db, $firstname);
	$lastname = mysqli_real_escape_string($db, $lastname);
	$password = mysqli_real_escape_string($db, $password);
    $address = mysqli_real_escape_string($db, $address);
    
    $req = "UPDATE users SET firstname='$firstname', lastname='$lastname', password='$password', address='$address' WHERE name = '$name'";
    if (mysqli_query($db, $req) === TRUE)
        return TRUE;
    return array('error');
}

function admin_exist($login) {
    $db = connect_database();

    $login = mysqli_real_escape_string($db, $login);
    $req = "SELECT * FROM users WHERE login = '$login' AND isAdmin = 1";
    $req = mysqli_query($db, $req);
    if (!$req)
        return NULL;
    return mysqli_fetch_assoc($req);
}

function get_all_users() {
    $db = connect_database();

    $req = mysqli_query($db, "SELECT * FROM users WHERE isAdmin = 0");
    if (!$req)
        return NULL;
    return mysqli_fetch_all($req, MYSQLI_ASSOC);
}
