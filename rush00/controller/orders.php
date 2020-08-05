<?php

session_start();

require_once('../model/user.php');
require_once('../model/stock.php');
require_once('../model/order_has_prod.php');
require_once('../model/orders.php');

$functions = array('get_order', 'del_order', 'add_order', 'basket');

function get_order(array $data) {
    if (!$data['order_id'] || !is_numeric($data['order_id']))
        return (array('order_id'));
}

function del_order(array $data) {
    if (!$data['login'])
        return (array('login'));
    $user = user_exist($data['login']);
    if ($user) {
        if (del_orders_has_prod($user['id']) === TRUE)
            return NULL;
        else
            return (array("order" => "not_exist"));
    }
    else
        return (array("login" => "not_exist"));
}

function add_order(int $product_id, int $quantity, string $login) {
    $user = user_exist($login);
    if ($user) {
        $stock = get_stock_byid($product_id);
        if ($stock >= $quantity) {
            if (get_order_byid($user['id']) === NULL)
                create_order($user['id']);
            $order = get_order_byid($user['id']);
            if ($order) {
                $prod = add_prod_to_order($product_id, $order['id'], $quantity);
                if ($prod === TRUE) {
                    update_stock_product_byid($product_id, $stock - $quantity);
                    return NULL;
                }
                else
                    return (array("add_order" => "fail"));
            }
            return (array("command_found"));
        }
        else
            return (array("out_of_stock" => $stock));
    }
    else
        return (array("login" => "not_exist"));
}

function basket() {
    $basket = unserialize($_SESSION['basketMovie']);

    if ($_SESSION['login']) {
        foreach ($basket as $k => $v) {
            $ret = add_order($k, $v, $_SESSION['login']);
            if ($ret !== NULL)
                $err[] = $ret;
        }
        return $err;
    }
    return (array("not_connected"));
}

if ($_POST['from'] && in_array($_POST['from'], $functions)) {
    if ($err = $_POST['from']($_POST)) {
        $str_err = http_build_query($err);
        header('Location: ../' . $_POST['from'] . '.php?' . $str_err);
    }
    else
        header('Location: ../' . $_POST['success'] . '.php');
}

?>
