<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/Exception.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $message = trim($_POST['message']);

    if (empty($name) || empty($email) || empty($phone) || empty($message)) {
        echo "<script>alert('Please fill out all fields.'); window.location.href='contact.php';</script>";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Please enter a valid email address.'); window.location.href='contact.php';</script>";
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host = ''; // Enter smtp host here
        $mail->SMTPAuth = true;
        $mail->Username = ''; // Enter email here
        $mail->Password = '';  // Enter your SMTP password here
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

        //Recipients
        $mail->setFrom('', 'Contact Form'); // Enter Sender email here
        $mail->addAddress('', 'Me'); // Enter reciver email here
        //$mail->addAddress('', 'Me'); 
        // Add more email to send mail

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Message from ' . $name;
        $mail->Body    = "You have received a new message.<br><br>Name: $name<br>Email: $email<br>Subject: $subject<br>Message: $message";

        // Send the email
        $mail->send();
        // Success message
        echo "<script>alert('Message has been sent successfully!'); window.location.href='contact.php';</script>";
    } catch (Exception $e) {
        // Error message
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}'); window.location.href='contact.php';</script>";
    }
}
?>
