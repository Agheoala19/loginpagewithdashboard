<?php
session_start();
include 'database.php';

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
    <title>User</title>
    <script src="script.js"></script>
    <link rel="stylesheet" href="styles3.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!--STYLE -->
<style>
    .sidebar {
    position: absolute;
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
.w-450 {
	width: 450px;
}
.vh-100 {
	min-height: 100vh;
}
.w-350 {
	width: 350px;
}
</style>
</head>
<body>
<div class="body">
<!-- CONTENT -->
        <div class="wrapper">
            <form action="editprofile.php" method="post" class="d-flex justify-content-center align-items-center vh-100" enctype="multipart/form-data" id="form">
                <div class="shadow w-450 p-3">
                    <?php
                        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                            $s_name = $_POST['new'];
                            $errors = array();
                            
                            $sql = "SELECT * FROM registration WHERE userName = '$s_name'";
                            $result = mysqli_query($conn, $sql);
                            $rowCount = mysqli_num_rows($result);

                            $file = $_FILES['image'];
                            $file_name = $_FILES['image']['name'];
                            $tempname = $_FILES['image']['tmp_name'];
                            $folder = 'img/'.$file_name;

                            $oldpass = $_POST['old'];
                            $newpass = $_POST['change'];

                            $sql3 = "SELECT * FROM registration WHERE email = '$sessionemail'";
                            $result3 = mysqli_query($conn, $sql3);
                            $row2 = mysqli_fetch_assoc($result3);
                            
                            if (isset($_POST['save'])) {
                                if($s_name != '') {
                                    $sql2 = "UPDATE registration SET userName='$s_name' WHERE email='$sessionemail'";
                                    $result2=mysqli_query($conn, $sql2);
                                    if($rowCount > 0) {
                                        array_push($errors, "Username is taken!");
                                    } else {
                                        echo "<div class='alert alert-success'>Username Has Been Saved</div>";
                                    }
                                }
                                if($file_name != '') {
                                    $query = mysqli_query($conn,"UPDATE registration SET image =  '$file_name' WHERE email = '$sessionemail'");
                            
                                    if(move_uploaded_file($tempname, $folder)) {
                                        echo "<div class='alert alert-success'>File uploaded successfully</div>";
                                    }else {
                                        array_push($errors,"Something went wrong with the file you're trying to upload");
                                    }
                                }
                                if($oldpass != '' && $newpass != '') {
                                    if($oldpass != $row2['password']) {
                                        array_push($errors, 'Old password is not correct');
                                    }elseif(strlen($newpass) < 8) {
                                        array_push($errors,'Password must be at least 8 characters long');
                                    }else {
                                        $query2 = mysqli_query($conn, "UPDATE registration SET password = '$newpass' WHERE email='$sessionemail'");
                                        echo "<div class='alert alert-success'>New password set successfully</div>";
                                    }
                                }
                                if(count($errors) > 0) {
                                    foreach($errors as $error) {
                                        echo "<div class='alert alert-danger'>$error</div>";
                                    }
                                }
                            }
                        }
                    ?>
                    <h4 class="display-4 fs-1">Edit Profile</h4><br>
                    <div class="mb-3" style="width: 100%; display: flex; justify-content: center;">
                        <?php 
                        $res = mysqli_query($conn, "select * from registration where email = '$sessionemail'");
                        while($row = mysqli_fetch_assoc($res)) {
                        ?>
                        <img src="img/<?php echo $row['image'] ?>" width="200" height="200" class="img-thumbnail" alt="User Profile Picture">
                        <?php }?>
                    </div>
                    <div class="mb-3">
                        <input type="file" class="form-control" id="image" name="image" accept=".jpg, .jpeg, .png, .jfif">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">New username:</label>
                        <input type="text" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" name="new" id="new">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Change password:</label>
                        <input type="password" class="form-control" placeholder="Old password" aria-label="Password" aria-describedby="basic-addon1" name="old" style="margin-bottom: 15px;">      
                        <input type="password" class="form-control" placeholder="New password" aria-label="Password" aria-describedby="basic-addon1" name="change">      
                    </div>
                    <div class="d-flex p-2 justify-content-center">
                    <button type="submit" class="btn btn-primary" id="save" name="save">Save</button>
                    </div>
                </div>
            </form>
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
                    <span class="links_name">Messages</span>
                </a>
                <span class="tooltip">Messages</span>
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
<!-- SCRIPT -->
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
</html>