<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$config = require '../httpd.private/config/config.php';


if (isset($_POST["submit"])) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true;
        $mail->Host = 'mailout.one.com';
        $mail->Username = $config['s_y'];
        $mail->Password = $config['s_o'];
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom($config['s_y'], 'Contact Form');
        $mail->addAddress($config['s_y']);
        $mail->addReplyTo($_POST['email'], $_POST['name']);

        $mail->isHTML(true);
        $mail->Subject = "New message from " . $_POST['name'];
        $mail->Body = "You have received a new message from {$_POST['name']} ({$_POST['email']}):<br><br>" .
                      nl2br($_POST['message']);

        $mail->send();
        echo "<script>alert('Your message has been sent successfully!'); window.location.href = 'index.html';</script>";
    } catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}');</script>";
    }
}
?>
