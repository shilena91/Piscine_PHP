<?php
require_once('mysqli.php');

function get_all_categorizes() {
    $db = connect_database();
    $req = "SELECT * FROM categorizes ORDER BY name ASC";
    $req = mysqli_query($db, $req);
    if ($req !== FALSE)
        return mysqli_fetch_all($req, MYSQLI_ASSOC);
    return NULL;
}

function create_categorize(string $name) {
    $err = NULL;
    $db =  connect_database();
    if (strlen($name) < 3 || strlen($name) > 45)
        $err[] = 'name';
    if ($err !== NULL)
        return ($err);
    $name = mysqli_real_escape_string($db, $name);
    $req = "INSERT INTO categorizes (name) VALUES ('$name')";
    $req = mysqli_query($db, $req);
    return ($req);
}

function get_categorize(string $name) {
    $db = connect_database();
    $name = mysqli_real_escape_string($db, $name);
    $req = "SELECT * FROM categorizes WHERE name = '$name'";
    $req = mysqli_query($db, $req);
    if ($req !== FALSE)
        $req = mysqli_fetch_assoc($req);
    return ($req);
}

?>
