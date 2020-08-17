<?php

/*
** Create a file named read_img.php that will return to the browser the file 42.png
** with the right Content-Type.
*/

header('Content-Type: image/png');
readfile('../img/42.png');
