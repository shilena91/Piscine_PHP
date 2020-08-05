<?php

require_once('mysqli.php');

function get_prod_by_order(int $orders_id) {
    $db = connect_database();
    $req = "SELECT * FROM orders_has_products WHERE orders_id = '$orders_id'";
    $req = mysqli_query($db, $req);
    if ($req)
        return mysqli_fetch_all($req, MYSQLI_ASSOC);
    return NULL;
}

function del_orders_has_prod(int $orders_id) {
    $db = connect_database();
    $req = "DELETE FROM orders_has_products WHERE orders_id = '$orders_id'";
    $req = mysqli_query($db, $req);
    return ($req);
}

function add_prod_to_order(int $products_id, int $orders_id, int $quantity) {
    $db = connect_database();
    $get = "SELECT * FROM orders_has_products WHERE orders_id = '$orders_id' AND products_id = '$products_id'";
	$get = mysqli_query($db, $get);
	$get = mysqli_fetch_assoc($get);
	if ($get) {
		$quantity = $get['quantity'] + $quantity;
		$req = "UPDATE orders_has_products set quantity = $quantity WHERE orders_id = '$orders_id' AND products_id = '$products_id'";
		$req = mysqli_query($db, $req);
		return ($req);
    }
    else {
        $get = "SELECT * FROM products WHERE id = '$products_id'";
        $get = mysqli_query($db, $get);
        $get = mysqli_fetch_assoc($get);
        if ($get) {
            $price = $get['price'];
            $req = "INSERT INTO orders_has_products (orders_id, products_id, price, quantity)
                    VALUES ('$orders_id', '$products_id', '$price', '$quantity')";
            $req = mysqli_query($db, $req);
            return ($req);
        }
        else
            return FALSE;
    }   
}

?>