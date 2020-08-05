<?php

require_once('mysqli.php');

function create_order(int $id) {
    $db = connect_database();
    $req = "INSERT INTO orders (users_id) VALUES ('$id')";
    $req = mysqli_query($db, $req);
    return ($req);
}

function get_order_byid(int $id) {
    $db = connect_database();
    $req = "SELECT * FROM orders WHERE users_id = '$id'";
    $req = mysqli_query($db, $req);
    if ($req)
        return mysqli_fetch_assoc($req);
    return NULL;
}

function unique_multidimension_array($array, $key) {
    $temp_array = array();
    $i = 0;
    $key_array = array();

    foreach ($array as $v) {
        if (!in_array($v[$key], $key_array)) {
            $key_array[$i] = $v[$key];
            $temp_array[$i] = $v;
        }
        $i++;
    }
    return $temp_array;
}

function get_order_by_user_id(int $user_id) {
    $db = connect_database();
    $req = "SELECT * FROM orders INNER JOIN orders_has_products AS op ON op.orders_id
            INNER JOIN products ON products.id = op.products_id WHERE users_id = '$user_id'";
    $req = mysqli_query($db, $req);
    if ($req) {
        $req = mysqli_fetch_all($req, MYSQLI_ASSOC);
        return unique_multidimension_array($req, 'date_order');
    }
    return NULL;
}

?>
