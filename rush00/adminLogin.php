<?php

session_start();
require_once('../model/user.php');

if (isset($_SESSION['admin']) && !empty($_SESSION['admin'])) {
    header('Location: admin.php');
    exit();
}
include('partial/head.php');

?>
<body class="small">
    <div class="reg-log">
        <div class="circle"></div>
        <h1>Connect Admin</h1>
        <form action="controller/admin.php" method="POST">
            <input type="text" name="login" placeholder="Your login" class="" value="">
            <input type="password" name="password" placeholder="Your password" class="">
            <button type="submit">Submit</button>
            <input type="hidden" name="from" value="adminLogin">
            <input type="hidden" name="success" value="admin">
        </form>
    </div>
    