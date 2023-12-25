<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/Exception.php';
require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';


function sendMail($recipient, $subject, $message) {
    // Create a PHPMailer object
    $mail = new PHPMailer(true);

    try {
        // Set mailer to use SMTP
        $mail->isSMTP();

        // Enable SMTP debugging if needed
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;

        // Set the SMTP server details
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 587; // Use 465 for SSL
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls'; // Use 'ssl' for SSL

        // Set the SMTP username and password
        $mail->Username = "sapkota.king@gmail.com";
        $mail->Password = "dxkzwuyxdzeixzqi";

        // Set the 'from' address, recipient, subject, and message body
        $mail->setFrom("sapkota.king@gmail.com", "Narayan Sapkota");
        $mail->addAddress($recipient);
        $mail->Subject = $subject;
        $mail->Body = $message;

        // Send the email
        $mail->send();
        return true;
    } catch (Exception $e) {
        return "Error while sending email: " . $mail->ErrorInfo;
    }
}
?>