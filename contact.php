<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>
    <script src="script.js"></script>
<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

* {
    font-family: 'Poppins', sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    min-height: 100vh;
    width: 100%;
    background: #1d1b31;
    display: flex;
    align-items: center;
    justify-content: center;
}

.wrapper {
    width: 26.25rem;
    background: transparent;
    border: none;
    color: black;
    border-radius: 10px;
    padding: 1.875rem 2.5rem;
    backdrop-filter: blur(12px);
    box-shadow: 0 0 10px rgba(0, 0, 0, .2)
}

.container {
    width: 80%;
    background: none;
    border-radius: 6px;
    padding: 30px 60px 40px 40px;
    
}

.container .content {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.container .content .left-side {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 25%;
    height: 100%;
    margin-top: 15px;
    position: relative; 
}

.container .content .left-side::before {
    content: '';
    position: absolute;
    width: 2px;
    height: 70%;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: #afafb6;
}

.container .content .left-side .details {
    margin: 14px;
    text-align: center;
}

.container .content .left-side .details i {
    font-size: 30px;
    color: #2f311b;
    margin-bottom: 10px;
}

.container .content .left-side .details .topic {
    font-size: 18px;
    font-weight: 700;
    color: #2f311b;
}

.container .content .left-side .details .text-one,
.container .content .left-side .details .text-two {
    font-size: 14px;
    color: #fff;
}

.container .content .right-side {
    width: 75%;
    margin-left: 75px;
}

.container .content .right-side .topic-text {
    font-size: 23px;
    font-weight: 600;
    color: #fff;
}

.container .content .right-side .input-box {
    height: 50px;
    width: 100%;
    margin: 12px 0;
}

.container .content .right-side .input-box input,
.container .content .right-side .input-box textarea {
    height: 100%;
    width: 100%;
    border: none;
    font-size: 16px;
    background-color: white;
    border-radius: 6px;
    padding: 0 15px;
    resize: none;
}

.container .content .right-side .message-box {
    min-height: 110px;
    margin-top: 6px;
}

.right-side .button {
    display: inline-block;
    margin-top: 6px;
}

.right-side .button input[type="button"] {
    color: #fff;
    font-size: 18px;
    background: #2f311b;
    border: none;
    border-radius: 6px;
    padding: 8px 16px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.right-side .button input[type="button"]:hover {
    background: #41432f;
}

@media (max-width: 950px ) {
    .container {
        width: 90%;
        padding: 30px 35px 40px 35px;
    } 
}

@media (max-width: 820px ) {
    .container {
        margin: 40px 0;
        padding: 20px 50px 30px 30px;
    } 

    .container .content {
       flex-direction: column-reverse; 
    }

    .container .content .left-side {
        width: 100%;
        flex-direction: row;
        margin-top: 40px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .container .content .left-side::before {
        display: none;
    }

    .container .content .right-side {
        width: 100%;
        margin-left: 0;
    }
    
}

.header {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    padding: 1.25rem 6.25rem;
    display: flex;
    justify-content: space-between;
    align-items: center;
    z-index: 100; 
}

.logo {
    color: #fff;;
    text-decoration: none;
    display: flex;
}

.logo:hover {
    color: #fff;
    text-decoration: none;
}

.navbar a {
    position: relative;
    font-size: 1.125rem;
    color:#fff;
    font-weight: 700;
    text-decoration: none;
    margin-left: 2.5rem;
}

.navbar a:hover {
    position: relative;
    font-size: 1.125rem;
    color:#fff;
    font-weight: 700;
    text-decoration: none;
    margin-left: 2.5rem;
}

.navbar a::before {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    width: 0;
    height: 0.125rem;
    background: #fff;
    transition: .3s;
}

.navbar a:hover::before {
    width: 100%;
}

.sidebar-nav {
    position: fixed;
    top: 0;
    right: 0;
    height: 100vh;
    width: 250px;
    z-index: 999;
    background-color: #fff;
    box-shadow: -10px 0 10px rgba(0, 0, 0, 0.1);
    display: none;
    flex-direction: column;
    justify-content: flex-start;
    align-items: flex-start;
    padding: 40px 50px 0 50px;
}

.side {
    position: relative;
    font-size: 1.125rem;
    color:#11101d;
    font-weight: 700;
    text-decoration: none;
    margin-top: 50px;
}

.side:hover {
    text-decoration: none;
    color: #11101d;
}

.side::before {
    content: '';
    position: absolute;
    top: 100%;
    left: 0;
    width: 0;
    height: 0.125rem;
    background: #11101d;
    transition: .3s;
}

.side:hover::before {
    width: 100%;
}

#menu-icon {
    display: none;
}

@media(max-width: 822px) {
    .hideOnMobile {
        display: none;
    }
    #menu-icon {
        display: block;
    }
    .logo {
        transform: scale(0.8);
    }
}

@media(max-width: 400px) {
    .sidebar {
        width: 100%;
    }
}

.logo i {
    font-size: 38px;
    margin-right: 5px;
    font-weight: 500;
}
.logo .logo_name {
    font-size: 30px;
    font-weight: 700;
}


    </style>
</head>
<body>
<header class="header">
        <a href="dashboard.php" class="logo"><i class='bx bxl-c-plus-plus'></i>
        <div class="logo_name">CodingLab</div></a>

        <nav class="navbar">
            <a href="dashboard.php" class="links hideOnMobile">Go Back</a>
            <a href="#" class="links hideOnMobile">About</a>
            <a href="contact.php" class="links hideOnMobile">Contact</a>
        </nav>
        <i class='bx bx-menu' id="menu-icon" onclick=showSidebar() style="transform: scale(2); cursor: pointer; color: #fff;"></i>
    </header>
    <header class="sidebar-nav">
        <i class='bx bxs-x-circle' onclick=hideSidebar() style="transform: scale(2); cursor: pointer; color: #11101d;"></i>
        <a href="dashboard.php" class="side">Go Back</a>
        <a href="#" class="side">About</a>
        <a href="contact.php" class="side">Contact</a>
    </header>
    <div class="wrapper"  style="width: 100%; height: 100vh; display: flex; align-items: center; justify-content: center;">
    <div class="container">
        <div class="content">
            <div class="left-side">
                <div class="address details">
                    <i class="bx bxs-map"></i>
                    <div class="topic">Address</div>
                    <div class="text-one">Birendranagar 06</div>
                    <div class="text-two">Surkhet, NP12</div>
                </div>
                <div class="phone details">
                    <i class="bx bxs-phone"></i>
                    <div class="topic">Phone</div>
                    <div class="text-one">0730569121</div>
                    <div class="text-two">021298776</div>
                </div>
                <div class="email details">
                    <i class="bx bxs-envelope"></i>
                    <div class="topic">Email</div>
                    <div class="text-one">codinglab@gmail.com</div>
                    <div class="text-two">info.codinglab@hotmail.com</div>
                </div>
            </div>
            <div class="right-side">
                <div class="topic-text">Send us a message</div>
            <form action="#">
                <div class="input-box">
                    <input type="text" placeholder="Enter your name">
                </div>
                <div class="input-box">
                    <input type="text" placeholder="Enter your email">
                </div>
                <div class="input-box message-box">
                    <textarea></textarea>
                </div>
                <div class="button">
                    <input type="button" value="Send Now">
                </div>
            </form>
            </div>
        </div>
    </div>
    </div>
</body>
</html>