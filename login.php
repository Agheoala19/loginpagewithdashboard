<?php
session_start();
if(isset($_SESSION["user"])) {
    header("Location: dashboard.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body onload="getcookiedata()">
    <header class="header">
        <a href="#" class="logo"><i class='bx bxl-c-plus-plus'></i>
        <div class="logo_name">CodingLab</div></a>

        <nav class="navbar">
            <a href="login.php" class="links hideOnMobile">Login</a>
            <a href="register.php" class="links hideOnMobile">Register</a>
            <a href="#" class="links hideOnMobile">About</a>
            <a href="contact.php" class="links hideOnMobile">Contact</a>
        </nav>
        <i class='bx bx-menu' id="menu-icon" onclick=showSidebar() style="transform: scale(2); cursor: pointer; color: #fff;"></i>
    </header>
    <header class="sidebar-nav">
        <i class='bx bxs-x-circle' onclick=hideSidebar() style="transform: scale(2); cursor: pointer; color: #11101d;"></i>
        <a href="login.php" class="side">Login</a>
        <a href="register.php" class="side">Register</a>
        <a href="#" class="side">About</a>
        <a href="contact.php" class="side">Contact</a>
    </header>
    <div class="body">
    <div class="wrapper">
        <?php
        if(isset($_POST["login"])) {
            $email = $_POST['email'];
            $password = $_POST['password'];
            require_once "database.php";
            $sql = "SELECT * FROM registration WHERE email = '$email' AND password = '$password'";
            $result = $conn->query($sql);
            if($result->num_rows == 1) {
                session_start();
                $_SESSION["user"] = "yes";
                $_SESSION['email'] = $email;
                $_SESSION['password'] = $password;
                header("Location: dashboard.php");
                die();
            }else {
                echo "<div class='alert alert-danger'>Email does not exist or wrong password!</div>";
            }
        }
        ?>
        <form action="login.php" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="text" placeholder="Email" name = 'email' id= 'email' required>
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Password" name='password' id="pass" required>
                <i class='bx bxs-lock-alt'></i>
            </div>
            <div class="remember-forgot">
                <label for=""><input type="checkbox" id="rememberMe" onclick="setcookie()">Remember me</label>
                <a href="forgot.php">Forgot Password?</a>
            </div>
            <button type="submit" class="button" name="login">Login</button>
            <div class="register-link">
                <p>Don't have an account?</p> <a href="register.php">Register</a>
            </div>
            <div style="display: flex; align-items: center; justify-content: center; padding: 20px;">
                <a href="https://www.facebook.com/login.php" class="fb" style="border: none; background-color: transparent;">
                <img src="facebook-color-svgrepo-com.svg" alt="Facebook Logo Button" style="width: 35px; height: auto; margin-right: 30px; cursor: pointer;">
                </a>
                <a href="https://accounts.google.com/Login" class="google" style="border: none; background-color: transparent;">
                <img src="google-logo-search-new-svgrepo-com.svg" alt="Google Logo Button" style="width: 35px; height: auto; cursor: pointer;">
                </a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>