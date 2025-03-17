<?php
session_start();
include "database.php";

if(!isset($_SESSION["user"])) {
    header("Location: login.php");
}else {
    $sessionemail = $_SESSION['email'];
    $sessionpassword = $_SESSION['password'];
    $sql = "SELECT * FROM registration WHERE email = '$sessionemail' AND password = '$sessionpassword'";
    $query = mysqli_query($conn, $sql);
    $result = mysqli_fetch_assoc($query);
    $_SESSION['name'] = $result['userName'];
    $_SESSION['image'] = $result['image'];

}
?>
<!DOCTYPE html>
<html lang="en">
<!--HEAD-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="script.js" defer></script>
    <link rel="stylesheet" href="styles3.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://widgets.skyscanner.net/widget-server/js/loader.js" async></script>

<!--STYLE-->

    <style>
.sidebar {
    position: fixed;
    height: 100vh;
    width: 78px;
    top: 0;
    left: 0;
    padding: 6px 14px;
    transition: all 0.5s ease;
    background-color: #11101d;
    z-index: 999;
}
.sidebar.active {
    width: 240px;
}
.sidebar.active ~ .wrapper {
    width: calc(100% - 240px);
    left: 240px;
}
.sidebar.active .logo_content .logo {
    opacity: 1;
    pointer-events: none;
}
.sidebar .logo_content .logo {
    color: #fff;
    display: flex;
    height: 50px;
    width: 100%;
    align-items: center;
    opacity: 0;
    pointer-events: none;
    transition: all 0.5s ease;
}
.buttons {
    text-align: center;
    font-size: 18px;
    transition: all 0.3s ease;
    color: #fff;
}
.buttons i {
    cursor: pointer;
}
.sidebar.active .buttons {
    display: flex;
    justify-content: space-between;
}
.logo_content .logo i {
    font-size: 28px;
    margin-right: 5px;
}
.logo_content .logo .logo_name {
    font-size: 20px;
    font-weight: 400;
}
.sidebar #open {
    color: #FFF;
    position: absolute;
    left: 50%;
    top: 6px;
    font-size: 20px;
    height: 50px;
    width: 50px;
    text-align: center;
    line-height: 50px;
    transform: translateX(-50%);
    cursor: pointer;
}
.sidebar.active #open{
    left: 90%;
}
.sidebar ul {
    margin-top: 20px;
}
.sidebar ul li {
    position: relative;
    width: 100%;
    height: 50px;
    margin: 0 5px;
    list-style: none;
    line-height: 50px;
}
.sidebar ul li .tooltip {
    position: absolute;
    left: 122px;
    top: 0;
    transform: translate(-50%, -50%);
    border-radius: 6px;
    height: 35px;
    width: 122px;
    background-color: #FFF;
    line-height: 35px;
    text-align: center;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
    transition: 0s;
    opacity: 0;
    pointer-events: none;
}
.sidebar.active ul li .tooltip {
    display: none;
}
.sidebar ul li:hover .tooltip {
    top: 50%;
    transition: all 0.5s ease;
    opacity: 1;
}
.sidebar ul li input {
    position: absolute;
    height: 100%;
    width: 100%;
    top: 0;
    left: 0;
    border-radius: 12px;
    outline: none;
    border: none;
    background: #1d1b31;
    padding-left: 50px;
    font-size: 18px;
    color: #fff;
}
.sidebar ul li a .links_name {
    opacity: 0;
    pointer-events: none;
    transition: all 0.5s ease;
}
.sidebar.active ul li a .links_name {
    opacity: 1;
    pointer-events: auto;
}
.sidebar ul li .bx-search {
    position: absolute;
    z-index: 999;
    color: #fff;
    font-size: 22px;
    transition: all 0.5s ease;
}
.sidebar ul li .bx-search:hover {
    background: #fff;
    color:#1d1b31
}
.sidebar.active ul li .bx-search:hover {
    color: #fff;
    background: #1d1b31
}
.sidebar ul li a {
    color: #fff;
    display: flex;
    align-items: center;
    text-decoration: none;
    border-radius: 12px;
    white-space: nowrap;
    transition: all 0.2s ease;
}
.sidebar ul li a:hover {
    color: #11101d;
    background-color: #fff;
}
.sidebar ul li i {
    height: 50px;
    min-width: 50px;
    border-radius: 12px;
    line-height: 50px;
    text-align: center;
}
.sidebar .profile_content {
    position: absolute;
    color: #Fff;
    bottom: 0;
    left: 0;
    width: 100%;
}
.sidebar .profile_content .profile {
    position: relative;
    padding: 10px 6px;
    height: 60px;
    background-color: #1d1b31;
}
.profile_content .profile .profile_details {
    display: flex;
    align-items: center;
    opacity: 0;
    pointer-events: none;
    white-space: nowrap;
    transition: all 0.5s ease;
}
.profile .profile_details img {
    height: 45px;
    width: 45px;
    object-fit: cover;
    border-radius: 12px;
}
.profile .profile_details .name_job {
    margin-left: 10px;
}
.profile .profile_details .name {
    font-size: 15px;
    font-weight: 400;
}
.profile .profile_details .job {
    font-size: 12px;
}
.profile a #log_out {
    position: absolute;
    left: 50%;
    bottom: 5px;
    transform: translateX(-50%);
    min-width: 50px;
    line-height: 50px;
    font-size: 20px;
    border-radius: 12px;
    text-align: center;
    transition: all 0.5s ease;
    color: #fff;
}
.sidebar.active .profile .profile_details {
    opacity: 1;
    pointer-events: auto;
}
.sidebar.active .profile #log_out {
    left: 88%;
}
footer {
    box-shadow: 0 0 10px rgba(0, 0, 0, .2);
    color: #fff;
    background: #11101d;
    backdrop-filter: blur(12px);
}
.single-content {
    text-align: center;
    padding: 115px 0;
}
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<!--BODY-->
<body>
<div class="body">
    <div class="wrapper">
        <h1>Welcome to Dashboard!</h1>
    </div>
    <div class="sidebar">
        <div class="logo_content">
            <div class="logo">
                <i class='bx bxl-c-plus-plus'></i>
                <div class="logo_name">CodingLab</div>
            </div>
            <i class='bx bx-menu' id="open" style="z-index: 999;"></i>
        </div>
        <ul class="nav_list">
            <li>
                <i class='bx bx-search'></i>
                <input type="text" placeholder="Search..." id="myInput" onkeyup="searchBar()">
                <span class="tooltip">Search</span>
            </li>
            <div id="list">
            <li>
                <a href="dashboard.php">
                    <i class='bx bx-grid-alt'></i>
                    <span class="links_name">Dashboard</span>
                </a>
                <span class="tooltip">Dashboard</span>
            </li>
            <li>
                <a href="user.php">
                    <i class='bx bx-user'></i>
                    <span class="links_name">User</span>
                </a>
                <span class="tooltip">User</span>
            </li>
            <li>
                <a href="chatbot.html">
                    <i class='bx bx-code-alt'></i>
                    <span class="links_name">CodingBotAI</span>
                </a>
                <span class="tooltip">CodingBotAI</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-pie-chart-alt-2'></i>
                    <span class="links_name">Analytics</span>
                </a>
                <span class="tooltip">Analytics</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-folder-open'></i>
                    <span class="links_name">File Manager</span>
                </a>
                <span class="tooltip">File Manager</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-cart-alt'></i>
                    <span class="links_name">Order</span>
                </a>
                <span class="tooltip">Order</span>
            </li>
            <li>
                <a href="#">
                    <i class='bx bx-heart'></i>
                    <span class="links_name">Saved</span>
                </a>
                <span class="tooltip">Saved</span>
            </li>
            <li>
                <a href="settings.php?mode=n">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
            </div>
        </ul>
        <div class="profile_content">
            <div class="profile">
                <div class="profile_details">
                    <img src="img/<?= $_SESSION['image'] ?>" alt="your profile picture">
                    <div class="name_job">
                        <div class="name"><?=$_SESSION['name']?></div>
                        <div class="job">Web Designer</div>
                    </div>
                </div>
                <a href="logout.php"><i class='bx bx-log-out' id="log_out"></i></a>
            </div>
        </div>
    </div>
</div>
<!--SCRIPT-->
    <script>
        let open = document.querySelector("#open");
        let sidebar = document.querySelector(".sidebar");
        let searchOpen = document.querySelector(".bx-search");
        let body = document.querySelector(".wrapper");

        body.onclick = function() {
            sidebar.classList.remove("active");
        }
        open.onclick = function() {
            sidebar.classList.toggle("active");
        }
        searchOpen.onclick = function() {
            sidebar.classList.toggle("active");
        }
    </script>
</body>
<!--FOOTER-->
<footer class="pt-5 pb-4">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">
            <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-light">About Us</h5>
                <hr class="mb-4" style="background-color: white;">
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid eligendi repellendus magnam harum voluptatibus. Vel qui repellat hic impedit perferendis eius voluptatibus asperiores, dolorem autem placeat minima optio quibusdam facere?</p>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-light">Let Us Help</h5>
                <hr class="mb-4" style="background-color: white;">
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Your Account</a>
                </p>
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Your Orders</a>
                </p>
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Manage Your Content And Devices</a>
                </p>
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Help</a>
                </p>
            </div>
            <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-light">Make Money</h5>
                <hr class="mb-4" style="background-color: white;">
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Sell Products on Our Website</a>
                </p>
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Advertise Your Product</a>
                </p>
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Become An Affiliate</a>
                </p>
                <p>
                    <a href="#" class="text-light" style="text-decoration: none;">Self-Publish</a>
                </p>
            </div>
            <div class="col-md-4 col-lg-3 col-xl-3 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold text-light">Contact</h5>
                <hr class="mb-4" style="background-color: white;">
                <p>
                    <li class="bx bxs-home mr-3 text-light"></li>New York NY 2333, US
                </p>
                <p>
                    <li class="bx bxs-envelope mr-3 text-light"></li>New York NY 2333, US
                </p>
                <p>
                    <li class="bx bxs-phone mr-3 text-light"></li>New York NY 2333, US
                </p>
                <p>
                    <li class="bx bxs-printer mr-3 text-light"></li>New York NY 2333, US
                </p>
            </div>
            </div>
            <hr class="mb-4" style="background-color: white;">
            <div class="row d-flex justify-content-center">
                <div>
                    <p>
                        Copyright 2020 All Rights Reserved By:
                        <a href="#"style="text-decoration: none;">
                            <strong class="text-light">Codinglab.com</strong>
                        </a>
                    </p>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
                <div class="text-center">
                    <ul class="list-unstyled list-inline">
                        <li class="list-inline-item">
                            <a href="" class="text-light"><li class="bx bxl-facebook"></li></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="" class="text-light"><li class="bx bxl-instagram-alt"></li></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="" class="text-light"><li class="bx bxl-twitter"></li></a>
                        </li>
                        <li class="list-inline-item">
                            <a href="" class="text-light"><li class="bx bxl-youtube"></li></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>
</html>
