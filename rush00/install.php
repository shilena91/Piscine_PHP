<?php

require_once('model/categories.php');
require_once('model/products.php');
require_once('model/prod_has_cat.php');

function connect_database2() {
    $add = "localhost";
    $user = "root";
    $pass = "123456";

    $mysqli = mysqli_connect($add, $user, $pass);
    if (mysqli_connect_errno($mysqli)) {
        echo "Error connect to database: " . mysqli_connect_error();
        return NULL;
    }
    return $mysqli;
}

$db = connect_database2();
$sql = "DROP DATABASE `rush00`;";
$req = mysqli_query($db, $sql);

var_dump(mysqli_error($db));

$sql = "CREATE DATABASE `rush00`";
$req = mysqli_query($db, $sql);

var_dump(mysqli_error($db));

$db = connect_database();
$sql = "CREATE DATABASE `rush00`";
$req = mysqli_query($db, $sql);

$db = connect_database();
$sql = "SET FOREIGN_KEY_CHECKS=0;";
$req =  mysqli_query($db, $sql);

$sql = "CREATE TABLE `users` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `login` varchar(45) NOT NULL,
    `email` varchar(255) NOT NULL,
    `password` varchar(100) NOT NULL,
    `isAdmin` tinyint(1) DEFAULT '0',
    `firstname` varchar(45) NOT NULL,
    `lastname` varchar(45) NOT NULL,
    `address` varchar(100) NOT NULL,
    `cookie` varchar(100) DEFAULT NULL,
    `valid` varchar(45) DEFAULT NULL COMMENT 'empty if user is valid/filled with a key if user have to get registered',
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    UNIQUE KEY `login_UNIQUE` (`login`),
    UNIQUE KEY `email_UNIQUE` (`email`))
    ENGINE=InnoDB AUTO_INCREMENT=56 DEFAULT CHARSET=utf8;";

$req = mysqli_query($db, $sql);
var_dump(mysqli_error($db));

$sql = "CREATE TABLE `categorizes` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(45) NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`))
    ENGINE=InnoDB AUTO_INCREMENT=128 DEFAULT CHARSET=utf8;";

$req = mysqli_query($db, $sql);
var_dump(mysqli_error($db));

$sql = "CREATE TABLE `products` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(100) NOT NULL,
    `price` double unsigned NOT NULL,
    `databaseid` int(10) unsigned NOT NULL,
    `isAdult` tinyint(1) DEFAULT '0',
    `picture` varchar(50) DEFAULT NULL,
    `stock` int(10) unsigned DEFAULT 10,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    UNIQUE KEY `databaseid_UNIQUE` (`databaseid`))
    ENGINE=InnoDB AUTO_INCREMENT=3677 DEFAULT CHARSET=utf8;";

$req = mysqli_query($db, $sql);
var_dump(mysqli_error($db));

$sql = "CREATE TABLE `product_has_categorizes` (
    `products_id` int(10) unsigned NOT NULL,
    `categorizes_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`products_id`,`categorizes_id`),
    KEY `fk_product_has_categorizes_categorizes1_idx` (`categorizes_id`),
    KEY `fk_product_has_categorizes_products_idx` (`products_id`),
    CONSTRAINT `fk_product_has_categorizes_categorizes1` FOREIGN KEY (`categorizes_id`) REFERENCES `categorizes` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_product_has_categorizes_products` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION )
    ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$req = mysqli_query($db, $sql);
var_dump(mysqli_error($db));

$sql = "CREATE TABLE `orders` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
    `date_order` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `users_id` int(10) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    UNIQUE KEY `id_UNIQUE` (`id`),
    KEY `fk_orders_users1_idx` (`users_id`),
    CONSTRAINT `fk_orders_users1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION)
    ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;";

$req = mysqli_query($db, $sql);
var_dump(mysqli_error($db));

$sql = "CREATE TABLE `orders_has_products` (
    `orders_id` int(10) unsigned NOT NULL,
    `products_id` int(10) unsigned NOT NULL,
    `price` double unsigned NOT NULL,
    `quantity` int(10) unsigned NOT NULL,
    PRIMARY KEY (`orders_id`,`products_id`),
    KEY `fk_orders_has_products_products1_idx` (`products_id`),
    KEY `fk_orders_has_products_orders1_idx` (`orders_id`),
    CONSTRAINT `fk_orders_has_products_orders1` FOREIGN KEY (`orders_id`) REFERENCES `orders` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
    CONSTRAINT `fk_orders_has_products_products1` FOREIGN KEY (`products_id`) REFERENCES `products` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION)
    ENGINE=InnoDB DEFAULT CHARSET=utf8;";

$req = mysqli_query($db, $sql);
var_dump(mysqli_error($db));

$db = connect_database();
$req = mysqli_query($db, $req);
$api_key = '?api_key=f823295cc0b86332b67712a3302e8e56';
$request_base = 'http://api.themoviedb.org/3/movie/';
$time = microtime(TRUE);
echo "This may take several minutes";
$start = 500;
$max =  $start + 600;
for ($i = $start; $i < $max; $i++) {
    $price = (float)(mt_rand(80, 260) / 10);
    $a =  @file_get_contents($request_base . $i . $api_key);
    if ($a)
        $data = (array)json_decode($a);
    else {
        $max++;
        $data = NULL;
    }
    if ($data) {
        if (isset($data['status_code']) && $data['status_code'] != 1)
            echo "The API return an error:" . $data['status_message'] . "\n";
        else {
            $genre = ((array)((array)($data['genres'])[0]))['name'];
            $price = (mt_rand(80, 300) / 10);
            if ($genre && !get_categorize($genre))
                create_categorize($genre);
            $ret = create_product($data['original_title'], $data['poster_path'], $data['adult'], $price, $i);
            if ($ret === TRUE && $genre) {
                echo "Current category: " . get_categorize($genre) . "<br />";
                $cat = get_categorize($genre);
                if ($cat) {
                    echo "Category capture: <strong>ok</strong><br/>";
                    $prod = get_product_byname($data['original_title']);
                    echo "Name capture: <strong>ok</strong><br/>";
                    add_category_to_prod($cat['id'], $prod['id']);
                }
            }
            else
                echo "<br/><strong>Create failed\n</strong> :" . $data['original_title'] . "<br />"; var_dump($ret);
        }
    }
    if ($i % 40 == 0) {
        $wait = 1000 + $time - microtime(true);
        if ($wait > 0)
            usleep($wait);
        $time = microtime(TRUE);
    }
}

?>