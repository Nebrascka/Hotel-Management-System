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
    $mail->Password = 'vixdhyeysntrcrfa';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;
    $mail->isHTML(true);

    // Set up email content
    $mail->setFrom('jodero380@gmail.com', 'ROOM 004');
    $mail->addAddress('jackjax617@gmail.com', 'Recipient Name');
    $mail->Subject = 'Test Email';
    $mail->Body = "
        <html>
            <head></head>
            <body>
                <h1>Test email</h1>
                <p>This is a test</p>
            </body>
        </html>
    ";

    // Send the email
    $mail->send();

    echo 'Email sent successfully.';
} catch (Exception $e) {
    echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
}
