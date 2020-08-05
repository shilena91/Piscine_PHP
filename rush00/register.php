<?php
    session_start();

    if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
        header('Location: index.php');
        exit();
    }

    include('partial/head.php');
?>
<body class="small">
    <div class="reg-log">
        <div class="circle"></div>
        <h1>Register</h1>
        <form action="controller/user.php" method="POST">
            <input type="text" name="name" placeholder="Your name" value="" class="<?php echo isset($_GET['name']) ? 'error' : ''; ?>">
            <input type="password" name="password" placeholder="Your password" class="<?php echo isset($_GET['password']) ? 'error' : '' ?>">
            <input type="password" name="password2" placeholder="Confirm your password" class="<?php echo isset($_GET['password']) ? 'error' : '' ?>">
            <input type="email" name="email" placeholder="Your email" class="<? echo isset($_GET['email']) ? 'error' : '' ?>">
            <input type="text" name="firstname" placeholder="Your first name" class="<?php echo isset($_GET['firstname']) ? 'error' : '' ; ?>">
            <input type="text" name="lastname" placeholder="Your last name" class="<?php echo isset($_GET['lastname']) ? 'error' : '' ; ?>">
            <input type="text" name="address" placeholder="Your address" class="<?php echo isset($_GET['address']) ? 'error' : '' ; ?>">
            <button type="submit">Register</button>
            <input type="hidden" name="from" value="register">
            <input type="hidden" name="success" value="login">
            <p>Are you already registered? <a href="login.php">Login</a></p>
        </form>
    </div>
