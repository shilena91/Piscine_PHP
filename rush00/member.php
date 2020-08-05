<?php
session_start();

require_once('model/user.php');
require_once('model/orders.php');
require_once('model/order_has_prod.php');
require_once('model/products.php');

if (!isset($_SESSION['login']) || empty($_SESSION['login'])) {
    header('Location: index.php');
    exit();
}

$user = user_exist($_SESSION['login']);
if ($user === NULL) {
    header('Location: index.php');
    exit();
}

$orders = get_order_by_user_id($user['id']);

include('partial/header.php');
?>
<div class="container">
    <div class="row">
        <div class="col-l-6">
            <h2>Edit my information</h2>
            <form action="controller/user.php" method="POST">
                <input type="password" name="password" placeholder="Your new password" value=""
                        class="<?php echo isset($_GET['password']) ? 'error' : ''; ?>">
                <input type="text" name="firstname" placeholder="Your firstname" value="<?php echo $user['firstname']; ?>"
                        class="<?php echo isset($_GET['firstname']) ? 'error' : ''; ?>">
                <input type="text" name="lastname" placeholder="Your lastname" value="<?php echo $user['lastname']; ?>"
                        class="<?php echo isset($_GET['lastname']) ? 'error' : ''; ?>">
                <input type="text" name="address" placeholder="Your address" value="<?php echo $user['address']; ?>"
                        class="<?php echo isset($_GET['address']) ? 'error' : ''; ?>">
                <button type="submit">Modify</button>
                <input type="hidden" name="success" value="member">
                <input type="hidden" name="from" value="update">
                <input type="hidden" name="error" value="member">
            </form>
        </div>
        <div class="col-l-6">
            <h2>My orders</h2>
            <?php
                if ($orders) {
                    foreach ($orders as $o) {
                        echo "<h5>Orders from " . $o['date_order'] . "</h5>";
                        ?>
                        <table class="basket">
                            <tbody>
                                <?php
                                $products = get_prod_by_order(intval($o['orders_id']));
                                foreach ($products as $p2) {
                                    $p = get_product_byid($p2['products_id']);
                                    ?>
                                    <tr>
                                        <td><a href="movie.php?id=<?php echo $p['id']; ?>"><?php echo $p['id']; ?></a></td>
                                        <td class="title"><a
                                                href="movie.php?id=<?php echo $p['id']; ?>"><?php echo $p['name']; ?></a>
                                        </td>
                                        <td class="right"><?php echo number_format($p2['quantity'], 0); ?></td>
                                        <td class="right"><?php echo number_format($p2['price'] * $p2['quantity'], 2); ?> €</td>
                                    </tr>
                                    <?php
                                }
                            ?>
                            </tbody>
                        </table>
                        <?php
                    }
                    echo "</div>";
                }
            ?>
        </div>
    </div>
</div>
