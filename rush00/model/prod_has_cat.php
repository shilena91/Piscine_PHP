<?php

require_once('mysqli.php');

function add_category_to_prod(int $cat, int $prod) {
    $db = connect_database();
    $req = "INSERT INTO product_has_categorizes (products_id, categorizes_id) VALUES ('$prod', '$cat')";
    return mysqli_query($db, $req);
}

?>
