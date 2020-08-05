<?php
include('head.php');
?>
<header class="row">
    <div class="col-l-2 col-m-12 col-s-12 logo">
        <a href="index.php"><img src="img/logo.png" alt=""></a>
    </div>
    <div class="col-l-6 col-m-8 col-s-12 menu">
        <a href="index.php">HOME</a> |
        <a href="browse.php">DVD Selling</a> |
        <a href="basket.php">
            <?php
            echo isset($_SESSION['basketCount']) ? $_SESSION['basketCount'] : "0";
            ?> BASKET -
            <?php
            echo isset($_SESSION['basketPrice']) ? number_format($_SESSION['basketPrice'], 2) : '0.00';
            ?> €
        </a>
    </div>
    <div class="col-l-4 col-m-4 col-s-12 login">
        <?php
        if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
            echo '<a href="member.php">Hello '.$_SESSION['login'].'</a> | <a href="logout.php">Logout</a>';
        } else {
            echo '<a href="register.php">Register</a> | <a href="login.php">Login</a>';
        }
        ?>
    </div>
</header>
