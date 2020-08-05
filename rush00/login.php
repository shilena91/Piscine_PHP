<?php
    session_start();

    if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
        header('Location: index.php');
        exit();
    }
    
    include('partial/head.php')
?>
<body class="small">
    <div class="reg-log">
        <div class="circle"></div>
        <h1>Login</h1>
        <form action="controller/user.php" method="POST">
            <input type="text" name="name" placeholder="Your name" class="" value="">
            <input type="password" name="password" placeholder="Your password" class="">
            <button type="submit">Login</button>
            <input type="hidden" name="from" value="login">
            <input type="hidden" name="success" value="index">
            <p>You don't have any account? <a href="register.php">Register</a></p>
        </form>
    </div>
