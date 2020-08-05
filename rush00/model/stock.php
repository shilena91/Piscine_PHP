<?php

require_once('mysqli.php');

function get_stock_byid(int $id) {
    $db = connect_database();
    $req = "SELECT * FROM products WHERE id = '$id'";
    $req = mysqli_query($db, $req);
    if ($req)
        $req = mysqli_fetch_assoc($req);
    return $req['stock'];
}

function update_stock_product_byid(int $id, int $stock) {
    $db = connect_database();
    $req = "UPDATE products set stock = $stock WHERE id = '$id'";
    $req = mysqli_query($db, $req);
    return $req;
}

?>