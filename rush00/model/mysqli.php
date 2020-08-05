<?php
function connect_database() {
    $add = "localhost";
    $user = "root";
    $pass = "123456";
    $db = "rush00";

    $mysqli = mysqli_connect($add, $user, $pass, $db);
    if (mysqli_connect_errno($mysqli)) {
        echo "Error connecting to database: " . mysqli_connect_error();
        return NULL;
    }
    return $mysqli;
}
