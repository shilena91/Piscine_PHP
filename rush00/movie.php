<?php

session_start();

if (!$_GET['id'] || !is_numeric($_GET['id'])) {
    header('Location: browse.php');
    exit();
}

require_once('model/products.php');

$product = get_product_byid($_GET['id']);
if (!$product) {
    header('Location: browse.php');
    exit();
}

$movie = (array)json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'?api_key=f823295cc0b86332b67712a3302e8e56'));
$credits = (array)json_decode(file_get_contents('http://api.themoviedb.org/3/movie/'.$product['databaseid'].'/credits?api_key=f823295cc0b86332b67712a3302e8e56'));

include('partial/header.php');

?>
<div class="container">
    <h1 style="text-align: left;"><?php echo $product['name']; ?></h1>
    <div class="row movie">
        <div class="col-l-4 cover">
            <img src="http://image.tmdb.org/t/p/w185/<?php echo $product['picture']; ?>" alt="">
        </div>
        <div class="col-l-8">
            <dl>
                <dt>Released Date</dt>
                <dd><?php echo isset($movie['release_date']) ? $movie['release_date'] : 'unknown'; ?></dd>
                <dt>Original language</dt>
                <dd><?php echo isset($movie['original_language']) ? $movie['original_language'] : 'unknown'; ?></dd>
                <dt>Original title</dt>
                <dd><?php echo isset($movie['original_title']) ? $movie['original_title'] : 'unknown'; ?></dd>
                <dt>Genre</dt>
                <dd>Test</dd>
                <dt>Budget</dt>
                <dd><?php echo isset($movie['budget']) ? $movie['budget'] : 'unknown'; ?></dd>
                <dt>Revenue</dt>
                <dd><?php echo isset($movie['revenue']) ? $movie['revenue'] : 'unknown'; ?></dd>
                <dt>Production Companies</dt>
                <dd><?php
                        if (isset($movie['production_companies'])) {
                            foreach ($movie['production_companies'] as $v) {
                                $v = (array)$v;
                                echo $v['name'].', ';
                            }
                        }
                    ?>
                </dd>
                <dt>Production Countries</dt>
                <dd><?php
                        if (isset($movie['production_countries'])) {
                            foreach ($movie['production_countries'] as $v) {
                                $v = (array)$v;
                                echo $v['name'].', ';
                            }
                        }
                    ?>
                </dd>
                <dt>Resume</dt>
                <dd><?php echo isset($movie['overview']) ? $movie['overview'] : 'unknown'; ?></dd>
            </dl>
            <div class="addBasket">
                <form action="basket.php" method="POST">
                    <input type="number" name="quantity" value="1">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <button type="submit">Add to basket</button>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <h3>Actors</h3>
        <?php
            if (isset($credits['cast'])) {
                foreach ($credits['cast'] as $v) {
                    $v = (array)$v;
                    echo '<div class="col-l-2 col-m-3 col-s-4">';
                    if (empty($v['profile_path']))
                        echo '<div class="actor" style="background-image: url(img/avatar.png)">';
                    else
                        echo '<div class="actor" style="background-image: url(http://image.tmdb.org/t/p/w185/'.$v['profile_path'].')">';
                            echo '<div class="title">';
                                echo '<p class="name">'.$v['name'].'</p>';
                                echo '<p>Role</p>';
                                echo '<p class="role">'.$v['character'].'</p>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                }
            }
        ?>
    </div>
</div>
<?php include('partial/footer.php');
