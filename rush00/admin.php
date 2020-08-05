<?php

session_start();

require_once('model/user.php');
require_once('model/products.php');
require_once('model/categories.php');

if (!isset($_SESSION['admin']) || empty($_SESSION['admin'])) {
    header('Location: index.php');
    exit();
}

$user = admin_exist($_SESSION['admin']);
if ($user === NULL) {
    header('Location: index.php');
    exit();
}

$users = get_all_users();
$categorizes = get_all_categorizes();
$products = get_products();

include('partial/header.php');

?>
<div class="container">
    <div class="row error">
    <?php
        foreach ($_GET as $k => $v) {
            echo '<div>'.$k.' : '.$v.'</div>';
        }
    ?>
    </div>
    <div class="row">
        <div class="col-l-6 padding">
            <h2>User</h2>
            <h5>Add</h5>
            <form action="controller/user.php" method="POST">
            <input type="text" name="login" placeholder="login">
                <input type="password" name="password" placeholder="password">
                <input type="email" name="email" placeholder="email">
                <input type="text" name="firstname" placeholder="firstname">
                <input type="text" name="lastname" placeholder="lastname">
                <input type="text" name="address" placeholder="address">
                <input type="hidden" name="from" value="register">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit">Add</button>
            </form>
            <h5>Remove</h5>
            <form action="controller/user.php" method="POST">
                <select name="login">
                    <?php
                        foreach ($users as $v) {
                            echo "<option value=''".$v['login']."'>".$v['login']." - ".$v['firstname']." ".$v['lastname']."</option>";
                        }
                    ?>
                </select>
                <input type="hidden" name="from" value="unregister">
                <input type="hidden" name="success" value="admin">
                <input type="hidden" name="error" value="admin">
                <button type="submit">Submit</button>
            </form>
            <h5>Modifier</h5>
            <form action="controller/user.php" method="POST">
            </form>
        </div>
    </div>
</div>