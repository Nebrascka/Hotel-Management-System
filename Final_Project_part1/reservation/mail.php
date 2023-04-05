<?php
// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '../vendor/autoload.php';
// Create a new PHPMailer object
$mail = new PHPMailer(true);

try {
    // Set up SMTP credentials
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'jodero380';
    $mail->Password = 'My0797865IOI';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    // Set up email content
    $mail->setFrom('jodero380@gmail.com', 'Your Name');
    $mail->addAddress('jackjax617@gmail.com', 'Recipient Name');
    $mail->Subject = 'Test Email';
    $mail->Body = 'This is a test email sent from PHPMailer.';

    // Send the email
    $mail->send();

    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
}
