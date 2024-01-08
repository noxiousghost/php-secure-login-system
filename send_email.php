<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';

function sendMail($recipient, $subject, $message)
{
    // PHPMailer object
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        // SMTP server details
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; // Use 465 for SSL
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; // Use 'ssl' for SSL
        // SMTP username and password
        // these are my own credentials you can add your own if you like
        $mail->Username = "youremail@gmail.com";
        $mail->Password = "your_app_password";
        // setting the 'from' address, recipient, subject, and message body
        $mail->setFrom("youremail@gmail.com", "Yourname");
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->Body = $message;
        // sneding the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Error while sending email: " . $mail->ErrorInfo;
    }
}
