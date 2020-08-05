<?php

require_once('mysqli.php');

function create_product(string $name, string $picture = NULL, bool $isAdult, float $price, int $databaseid) {
    $err = NULL;
    $db = connect_database();
    if (strlen($name) < 3 || strlen($name) > 100)
        $err[] = 'name';
    if ($picture != NULL && (strlen($picture) < 10 || strlen($picture) > 50))
        $err[] = 'picture';
    if ($price < 0)
        $err[] = 'price';
    if ($err !== NULL)
        return ($err);
    $name = mysqli_real_escape_string($db, $name);
    $picture = mysqli_real_escape_string($db, $picture);
    $isAdult = $isAdult == false ? 0 : 1;
    $req = "INSERT INTO products (name, picture, isAdult, price, databaseid) VALUES ('$name', '$picture', '$isAdult', '$price', '$databaseid')";
    $req = mysqli_query($db, $req);
    if ($req)
        return TRUE;
    return array('error');
}

function get_product_byname(string $name) {
    $db = connect_database();
    $name = mysqli_real_escape_string($db, $name);
    $req = "SELECT * FROM products WHERE name = '$name'";
    $req = mysqli_query($db, $req);
    if ($req)
        $req = mysqli_fetch_assoc($req);
    return ($req);
}

function get_product_byid(int $id) {
    $db = connect_database();
    $req = "SELECT * FROM products WHERE id = '$id'";
    $req = mysqli_query($db, $req);
    if ($req)
        $req = mysqli_fetch_assoc($req);
    return ($req);
}

function get_product_filter($cat, $min, $max, $name) {
    $db = connect_database();
    $req = "SELECT * FROM products INNER JOIN product_has_categorizes ON product_has_categorizes.products_id = products.id WHERE 1 = 1";
    if ($name) {
        $name = mysqli_real_escape_string($db, $name);
        $req .= " AND products.name LIKE '%$name%'";
    }
    if ($min) {
        $min = mysqli_real_escape_string($db, $min);
        $req .= " AND products.price >= '$min'";
    }
    if ($max) {
        $max = mysqli_real_escape_string($db, $max);
        $req .= " AND products.price <= '$max'";
    }
    if ($cat) {
        $cat = mysqli_real_escape_string($db, $cat);
        $req .= " AND product_has_categorizes.categorizes_id = '$cat'";
    }
    $req = mysqli_query($db, $req);
    if ($req)
        return mysqli_fetch_all($req, MYSQLI_ASSOC);
    return NULL;
}

function get_products() {
    $db = connect_database();
    $req = "SELECT * FROM products ORDER by name ASC";
    $req = mysqli_query($db, $req);
    if (!$req)
        return NULL;
    return mysqli_fetch_all($req, MYSQLI_ASSOC);
}

?>
