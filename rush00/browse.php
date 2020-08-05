<?php

session_start();

require_once('model/categories.php');
require_once('model/products.php');
include('partial/header.php');

$categorizes = get_all_categorizes();
$movie = get_product_filter($_GET['cat'], (float)$_GET['min'], (float)$_GET['max'], $_GET['name']);

?>
<div class="container">
<div class="row browse">
    <div class="col-l-3 col-m-2 col-s-12 filter">
        <h2>Filter</h2>
        <form action="">
            <input type="text" name="name" value="<?php echo isset($_GET['name']) ? $_GET['name'] : '';?>" placeholder="Movie name">
            <input type="number" name="min" value="<?php echo isset($_GET['min']) ? $_GET['min'] : '' ; ?>" placeholder="Price minimum" style="width:49%;">
            <input type="number" name="max" value="<?php echo isset($_GET['max']) ? $_GET['max'] : '' ; ?>" placeholder="Price maximum" style="width:49%;">
            <input type="hidden" name="cat" value="<?php echo $_GET['cat']; ?>">
            <button type="submit">Search</button>
        </form>
        <h2 style="margin-top: 30px;">Categorizes</h2>
        <ul>
            <?php
                foreach ($categorizes as $v) {
                    $filter = '';
                    $filter .= isset($_GET['name']) ? "&name=".$_GET['name'] : '';
                    $filter .= isset($_GET['min']) ? "&min=".$_GET['min'] : '';
                    $filter .= isset($_GET['max']) ? "&max=".$_GET['max'] : '';
                    if ($v['id'] == $_GET['cat'])
                        echo "<a href=browse.php?".$filter."'><li";
                    else
                        echo "<a href='browse.php?cat=" . $v['id'] . "".$filter."'><li";
                    echo $_GET['cat'] == $v['id'] ? " class='selected'" : '';
                    echo ">" . $v['name'] . "</li></a>";
                }
            ?>
        </ul>
    </div>
    <div class="col-l-9">
        <?php
            foreach ($movie as $v) {
                ?>
                <div class="col-l-3 col-m-4 col-s-6">
                    <a href="movie.php?id=<?php echo $v['id']; ?>">
                        <div class="movie"
                            style="background-image: url('http://image.tmdb.org/t/p/w185/<?php echo $v['picture']; ?>')">
                            <div class="price">
                                <div id="burst-12"></div>
                            </div>
                            <div class="price"><?php echo number_format($v['price'], 2); ?> €</div>
                            <div class="title"><?php echo $v['name']; ?></div>
                        </div>
                    </a>
                </div>
                <?php
            }
            ?>
    </div>        
</div>
</div>
<?php include('partial/footer.php'); ?>
