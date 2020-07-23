<?php

$user = $_SERVER['PHP_AUTH_USER'];
$password = $_SERVER['PHP_AUTH_PW'];

if (!$user || !$password || $user != 'zaz' || ($password != 'Ilovemylittleponey')) {
    header('HTTP/1.0 401 Unauthorized');
    header('WWW-Authenticate: Basic realm=\'\'Member area\'\'');

    echo '<html><body>That area is accessible for members only</body></html>' . "\n";
    exit;
}

?>
<html><body>
Hello Zaz<br />
<img src='<?php
    echo 'data:image/png;base64,';
    echo base64_encode(file_get_contents('../img/42.png'));
?>'>
</body></html>
