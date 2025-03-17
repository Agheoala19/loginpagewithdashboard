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
    <title>Register</title>
    <link rel="stylesheet" href="styles2.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
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
            if(isset($_POST["submit"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                $username = $_POST["username"];
                $errors = array();

                if(empty($email) OR empty($password) OR empty($username)) {
                    array_push($errors, "All fields are required");
                }
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }
                if(strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }
                require_once "database.php";
                $sql = "SELECT * FROM registration WHERE email = '$email'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if($rowCount > 0) {
                    array_push($errors, "Email already exists!");
                }

                $sql = "SELECT * FROM registration WHERE userName = '$username'";
                $result = mysqli_query($conn, $sql);
                $rowCount = mysqli_num_rows($result);
                if($rowCount > 0) {
                    array_push($errors, "Username is taken!");
                }

                if(count($errors) > 0) {
                    foreach($errors as $error) {
                        echo "<div class='alert alert-danger'>$error</div>";
                    }
                }else{
                    $sql = "INSERT INTO registration (email, userName, password) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    $prepareStmt = mysqli_stmt_prepare($stmt, $sql);
                    if($prepareStmt) {
                        mysqli_stmt_bind_param($stmt, "sss", $email, $username, $password);
                        mysqli_stmt_execute($stmt);
                        echo "<div class='alert alert-success'>You are registered successfully.</div>";
                    }else{
                        die("Something went wrong");
                    }
                }
            }
        ?>
        <form action="register.php" method="post">
            <h1>Register</h1>
            <div class="input-box">
                <input type="text" placeholder="Email" name="email">
                <i class='bx bxs-envelope'></i>
            </div>
            <div class="input-box">
                <input type="text" placeholder="Username" name="username">
                <i class='bx bxs-user'></i>
            </div>
            <div class="input-box">
                <input type="password" placeholder="Create password" name="password">
                <i class='bx bxs-lock-alt'></i>
            </div>
            <button type="submit" class="button" name="submit">Register</button>
            <div class="register-link">
                <p>Already have an account?</p> <a href="login.php">Login</a>
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