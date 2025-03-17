<?php
  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

  require "/vendor/autoload.php";

  $mail = new PHPMailer(true);
  
  try {
    $mail->SMTPDebug = 0;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';
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


  //File to use for sending emails!!!
?>
