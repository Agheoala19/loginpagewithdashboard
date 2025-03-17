<?php
    session_start();
    $errors = array();
    require_once "database.php";
    $mode = "enter_email";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;

    require "vendor/autoload.php";

    if(isset($_GET['mode'])) {
        $mode = $_GET['mode'];
    }

    if(count($_POST) > 0) {
        switch ($mode) {
            case 'enter_email':
                $email = $_POST['email'];
                $sql = "SELECT * FROM registration WHERE email = '$email'";
                $result = $conn->query($sql);
                //validate email
                if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    array_push($errors, "Email is not valid");
                }
                elseif($result->num_rows == 1) {
                    $_SESSION['forgot']['email'] = $email;
                    send_email($email);
                    header("Location: forgot.php?mode=enter_code");
                    die;
                }else {
                    array_push($errors, "Email doesen't exist");
                }
                break;

            case 'enter_code':
                $code = $_POST['code'];
                $result = correct_code($code);

                if($result == "C")
                {
                    $_SESSION['forgot']['code'] = $code;
                    header("Location: forgot.php?mode=enter_password");
                    die;    
                }else {
                    array_push($errors, $result);
                }
                break;
            
            case 'enter_password':
                $password = $_POST['password'];
                $password2 = $_POST['password2'];
                if($password !== $password2) {
                    array_push($errors, "Passwords do not match");
                }elseif(strlen($password) < 8) {
                    array_push($errors, "Password must be at least 8 characters long");
                }
                elseif(!isset($_SESSION['forgot']['email']) || !isset($_SESSION['forgot']['code'])) {
                    header("Location: forgot.php");
                    die;
                }else {
                    save_password($password);
                    if(isset($_SESSION['forgot']))
                    {
                        unset($_SESSION['forgot']);
                    }
                    header("Location: forgot.php?mode=finished");
                    die;
                }
                break;
            
            default:
                break;
        }
    }

    function send_email($email) {
        global $conn;
        $expire = time() + (60 * 1);
        $code = rand(10000, 99999);
        $email = addslashes($email);
        require_once "database.php";
        $query = "INSERT INTO codes (email, code, expire) VALUE ('$email', '$code', '$expire')";
        $conn->query($query);

        $mail = new PHPMailer(true);
  
        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.example.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'your_email@example.com';
            $mail->Password = 'your_password';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('noreply@example.com');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Password Reset';
            $mail->Body = '<p>Your password reset code is: <b style="font-size: 30px;">' . $code . '</b></p>';
            $mail->send();
        }catch(Exception $e) {
            echo "<div class='alert alert-danger'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
        }
    }
    function correct_code($code) {
        global $conn;
        $code = addslashes($code);
        $expire = time();
        $email = addslashes($_SESSION['forgot']['email']);
        require_once 'database.php';
        $query = "SELECT * FROM codes WHERE code = '$code' && email = '$email' && expire > '$expire' ORDER BY ID DESC LIMIT 1";
        $result = $conn->query($query);
        if($result) {
            if(mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                if($row['expire'] > $expire) {
                    return "C";
                }else {
                    return "Code has expired!";
                }
            }else {
                return "I";
            }
        }
        return "Incorrect code!";
    }

    function save_password($password) {
        global $conn;
        $password = addslashes($password);
        $email = addslashes($_SESSION['forgot']['email']);
        require_once "database.php";
        $query = "UPDATE registration SET password = '$password' WHERE email = '$email' LIMIT 1";
        $conn->query($query);
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <link rel="stylesheet" href="styles.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="script.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <header class="header">
        <a href="#" class="logo" style="margin-left: -70px;"><i class='bx bxl-c-plus-plus'></i>
        <div class="logo_name">CodingLab</div></a>
    </header>
    <div class="body">
        <?php
            switch ($mode) {
                case 'enter_email':
        ?>
                    <div class="wrapper">
                        <form method="post" action="forgot.php?mode=enter_email">
                            <h1>Forgot Password</h1>
                            <h3>Enter your email address</h3>
                            <?php
                                 if(count($errors) > 0) {
                                    foreach($errors as $error) {
                                        echo "<div class='alert alert-danger'>$error</div>";
                                    }
                                }
                            ?>
                            <div class="input-box">
                                <input type="text" placeholder="Email" name = 'email' id= 'email' required>
                                <i class='bx bxs-envelope'></i>
                            </div>
                            <button type="submit" class="button" name="continue">Continue</button>
                            <div class="register-link">
                            <a href="login.php">Go back to login page</a>
                            </div>
                        </form>
                    </div>
        <?php
                    break;
    
                case 'enter_code':
        ?>
                    <div class="wrapper">
                        <form method="post" action="forgot.php?mode=enter_code">
                            <h1>Forgot Password</h1>
                            <h3>We sent you a code on email!</h3>
                            <div class="input-box">
                                <input type="text" placeholder="Enter the code here..." name = 'code' id= 'code' required>
                                <i class='bx bx-vertical-bottom'></i>
                            </div>
                            <button type="submit" class="button" name="continue">Continue</button>
                            <div class="register-link">
                            <a href="forgot.php">Go back</a>
                            </div>
                        </form>
                    </div>
        <?php
                    break;
                
                case 'enter_password':
        ?>
                    <div class="wrapper">
                        <form method="post" action="forgot.php?mode=enter_password">
                            <h1>Forgot Password</h1>
                            <h3>Enter your new password</h3>
                            <div class="input-box">
                                <input type="text" placeholder="Create new password" name = 'password' id= 'password' required>
                                <i class='bx bxs-lock-alt'></i>
                            </div>
                            <div class="input-box">
                                <input type="text" placeholder="Retype your new password" name = 'password2' id= 'password2' required>
                                <i class='bx bxs-lock-open'></i>
                            </div>
                            <button type="submit" class="button" name="continue">Continue</button>
                            <div class="register-link">
                            <a href="forgot.php">Go back</a>
                            </div>
                        </form>
                    </div>
        <?php
                    break;
                
                case 'finished':
        ?>
                    <div class="wrapper">
                        <form method="" action="">
                            <h1 style="margin-bottom: 50px;">Your New Password has been set!</h1>
                            <div class="register-link">
                            <a href="logout.php" class="button" style="text-decoration: none; padding: 15px;">Go back to login page</a>
                            </div>
                        </form>
                    </div>
        <?php
                    break;
            }
        ?>
        </div>
    </div>
</body>
</html>