<?php

/*
** Create a file named print_get.php that will display all the variables passed in the url.
*/

foreach ($_GET as $k => $v) {
    echo $k . ': ' . $v . "\n";
}
