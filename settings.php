<?php
session_start();
include "database.php";
$mode = 'notifications';

if(isset($_GET['mode'])) {
    $mode = $_GET['mode'];
}

if(count($_POST) > 0) {
    switch($mode) {
        case 'n':
            header('Location: settings.php?mode=n');
            break;
        case 'a':
            header('Location: settings.php?mode=a');
            break;
    }
}

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
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Document</title>
<script src="script.js"></script>
<link rel="stylesheet" href="styles3.css">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"></body>
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
    .nav-link {
        color: black;
        transition: all 0.3s ease;
    }
    .nav-link.active {
        border: 1px solid #cccccc;
        background-color: white;
    }
    .nav-link:hover {
        color: black;
    }
    .toggle {
        width: 48px;
        height: 23px;
        border-radius: 40px;
        background-color: #ebebfb;
        display: inline-block;
    }
    .toggle-c {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background-color: white;
        display: inline-block;
        position: absolute;
        left: 5px;
        top: 5px;
        transition: 300ms all;
        border: 1px solid #8c8ca4;
    }
    .toggle-container {
        position: relative;
        width: fit-content;
        height: fit-content;
        cursor: pointer;
    }
    input[type="checkbox"] {
        opacity: 0;
        width: 48px;
        height: 23px;
        cursor: pointer;
        position:absolute;
        z-index: 999;
    }
    input[type="checkbox"]:checked + .toggle-container .toggle-c {
        left: 30px;
        background-color: #30305C;
        border-color: #30305C;
    }
</style>
</head>
<body>
    <!-- CONTENT -->
<div class="body">
<div class="wrapper">

    <?php
        switch($mode) {
            case 'a':
    ?>

    <div class="container" id="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <div class="my-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="notifications" data-toggle="tab" href="settings.php?mode=n" role="tab" aria-controls="contact" aria-selected="false" name="notifications">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="account" data-toggle="tab" href="settings.php?mode=a" role="tab" aria-controls="contact" aria-selected="false" name="account">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="system" data-toggle="tab" href="settings.php?mode=s" role="tab" aria-controls="contact" aria-selected="false" name="system">System</a>
                        </li>
                    </ul>
                    <h5 class="mb-0 mt-5">Account Settings</h5>
                    <p>Select notification you want to receive</p>
                    <hr class="my-4" />
                    <strong class="mb-0">Security</strong>
                    <p>Control security alert you will be notified.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Unusual activity notifications</strong>
                                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-1">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Unauthorized financial activity</strong>
                                    <p class="text-muted mb-0">Fusce lacinia elementum eros, sed vulputate urna eleifend nec.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-2">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <strong class="mb-0">System</strong>
                    <p>Please enable system alert you will get.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me about new features and updates</strong>
                                    <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-3">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me by email for latest news</strong>
                                    <p class="text-muted mb-0">Nulla et tincidunt sapien. Sed eleifend volutpat elementum.</p>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" id="togg-4">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me about tips on using account</strong>
                                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" id="togg-5">
                                        <div class="toggle-container">
                                            <span class="toggle"></span>
                                            <span class="toggle-c"></span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
            break;
        case 'n':
    ?>

    <div class="container" id="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <div class="my-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="notifications" data-toggle="tab" href="settings.php?mode=n" role="tab" aria-controls="contact" aria-selected="false" name="notifications">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="account" data-toggle="tab" href="settings.php?mode=a" role="tab" aria-controls="contact" aria-selected="false" name="account">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="system" data-toggle="tab" href="settings.php?mode=s" role="tab" aria-controls="contact" aria-selected="false" name="system">System</a>
                        </li>
                    </ul>
                    <h5 class="mb-0 mt-5">Notifications Settings</h5>
                    <p>Select notification you want to receive</p>
                    <hr class="my-4" />
                    <strong class="mb-0">Security</strong>
                    <p>Control security alert you will be notified.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Unusual activity notifications</strong>
                                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-1">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Unauthorized financial activity</strong>
                                    <p class="text-muted mb-0">Fusce lacinia elementum eros, sed vulputate urna eleifend nec.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-2">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <strong class="mb-0">System</strong>
                    <p>Please enable system alert you will get.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me about new features and updates</strong>
                                    <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-3">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me by email for latest news</strong>
                                    <p class="text-muted mb-0">Nulla et tincidunt sapien. Sed eleifend volutpat elementum.</p>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" id="togg-4">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me about tips on using account</strong>
                                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" id="togg-5">
                                        <div class="toggle-container">
                                            <span class="toggle"></span>
                                            <span class="toggle-c"></span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
            break;
        case 's':
    ?>

    <div class="container" id="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8 mx-auto">
                <div class="my-4">
                    <ul class="nav nav-tabs mb-4" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link" id="notifications" data-toggle="tab" href="settings.php?mode=n" role="tab" aria-controls="contact" aria-selected="false" name="notifications">Notifications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="account" data-toggle="tab" href="settings.php?mode=a" role="tab" aria-controls="contact" aria-selected="false" name="account">Account</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="system" data-toggle="tab" href="settings.php?mode=s" role="tab" aria-controls="contact" aria-selected="false" name="system">System</a>
                        </li>
                    </ul>
                    <h5 class="mb-0 mt-5">System Settings</h5>
                    <p>Select notification you want to receive</p>
                    <hr class="my-4" />
                    <strong class="mb-0">Security</strong>
                    <p>Control security alert you will be notified.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Unusual activity notifications</strong>
                                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-1">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Unauthorized financial activity</strong>
                                    <p class="text-muted mb-0">Fusce lacinia elementum eros, sed vulputate urna eleifend nec.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-2">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="my-4" />
                    <strong class="mb-0">System</strong>
                    <p>Please enable system alert you will get.</p>
                    <div class="list-group mb-5 shadow">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me about new features and updates</strong>
                                    <p class="text-muted mb-0">Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                </div>
                                <div class="col-auto">
                                <input type="checkbox" id="togg-3">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me by email for latest news</strong>
                                    <p class="text-muted mb-0">Nulla et tincidunt sapien. Sed eleifend volutpat elementum.</p>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" id="togg-4">
                                    <div class="toggle-container">
                                        <span class="toggle"></span>
                                        <span class="toggle-c"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <strong class="mb-0">Notify me about tips on using account</strong>
                                    <p class="text-muted mb-0">Donec in quam sed urna bibendum tincidunt quis mollis mauris.</p>
                                </div>
                                <div class="col-auto">
                                    <input type="checkbox" id="togg-5">
                                        <div class="toggle-container">
                                            <span class="toggle"></span>
                                            <span class="toggle-c"></span>
                                        </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php
            break;
        }
    ?>

</div>
<!-- SIDEBAR -->
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
                <input type="text" placeholder="Search...">
                <span class="tooltip">Search</span>
            </li>
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
                <a href="#">
                    <i class='bx bx-chat'></i>
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
                <a href="settings.php">
                    <i class='bx bx-cog'></i>
                    <span class="links_name">Settings</span>
                </a>
                <span class="tooltip">Settings</span>
            </li>
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
</body>
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
</html>