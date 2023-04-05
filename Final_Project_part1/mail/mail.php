<?php
require_once("../db/db.php");

// Import PHPMailer classes
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require '../vendor/autoload.php';

function sendEmail($recepient_name, $recepient_email, $subject, $body) {
    // Create a new PHPMailer object
    $mail = new PHPMailer(true);

    try {
        // Set up SMTP credentials
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'Conradadams24';
        $mail->Password = 'ctoentqabzdhcwpg';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;
        $mail->isHTML(true);

        // Set up email content
        $mail->setFrom('Conradadams24@gmail.com', 'MIRTH BOOKING');
        $mail->addAddress($recepient_email, $recepient_name);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Send the email
        $mail->send();

        header('../reservation/dashboard.php');
    } catch (Exception $e) {
        echo 'Email could not be sent. Error: ' . $mail->ErrorInfo;
    }
}

function generateRandomString($length = 7) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}

function addRefNo($ref, $id) {
    $pdo = establishCONN();

    $stmt = $pdo->prepare("UPDATE bookings SET reference_number = :ref WHERE bookings.application_id = :id");
    $stmt->bindValue(':ref', $ref);
    $stmt->bindValue(':id', $id);

    $stmt->execute();
}

$email_body = "";
$uid = $_GET["uid"];
$recepient_email = $_GET["addr"];
$recepient_name = $_GET["name"];
$price = $_GET["price"];
$room_no = "";

if($_SERVER["REQUEST_METHOD"] == "GET") {
    if($_GET["type"] === "verification") {
        $email_body = "
            <html>
                <head></head>
                <body style=\"padding: 24px; text-align: center; background-color: white;\">
                    <h4>MIRTH BOOKING | Verify your email addres.</h4><br>
                    <a style=\"padding: 7px 20px; border-radius: background-color: blue; color: white;\" href=\"https://13df-41-80-114-241.eu.ngrok.io/Hotel-Management-System/Final_Project_part1/reservation/verify.php?uid=". $uid . "\">Verify Email</a>
                </body>
            </html>
        ";

        sendEmail($recepient_name, $recepient_email, "Email Verification", $email_body);
    }elseif($_GET["type"] === "ticket") {
        $room_no = $_GET["roomno"];
        $ref_no = generateRandomString();
        $applId = $_GET["applId"];

        $email_body = "
            <html>
                <head></head>
                <body style=\"padding: 24px; text-align: center; background-color: white;\">
                    <h1>MIRTH BOOKING | Payment</h1>
                    <p>Payment received successfuly. Thank you for Using Mirth Hotel.</p> <p>Karibu for a good time.</p><br>
                    <table style=\"width: 100%;\">
                    <tr>
                        <th>Applicant:</th>
                        <th>Room number:</th>
                        <th>Amount paid:</th>
                        <th>Reference Number:</th>
                    </tr>
                    <tr>
                        <td>". $recepient_name ."</td>
                        <td>". $room_no . "</td>
                        <td>". $price . "</td>
                        <td>". $ref_no . " (DO NOT SHARE THIS WITH ANYONE)</td>
                    </tr>
                    </table>
                </body>
            </html>
        ";

        addRefNo($ref_no, $applId);
        sendEmail($recepient_name, $recepient_email, "Ticket Invoice", $email_body);
    }
    header('location: ../reservation/dashboard.php');
}