<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

if(isset($_POST['submit'])){
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST["email"];
    $message = $first_name . " " . $last_name . " heeft het volgende geschreven:" . "\n\n" . $_POST['message'];

    require "../vendor/autoload.php";

    $mail = new PHPMailer(true);

    $mail->SMTPDebug = SMTP::DEBUG_SERVER;

    $mail->isSMTP();
    $mail->SMTPAuth = true;

    $mail->Host = "mail.kpnmail.nl";
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->Username = "martijn.gerritsen@kpnmail.nl";
    include '../randomfile.php';
    $mail->Password = $magicstuf;
    
    $mail->setFrom($email, $first_name);
    $mail->addAddress("martijn.gerritsen@kpnmail.nl", "Martijn");

    $mail->Body = $message;

    $mail->send();

    header("Location: ../index.html");
}
?>