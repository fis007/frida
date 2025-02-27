<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer classes (adjust paths based on where you put PHPMailer)
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = htmlspecialchars($_POST['full-name']);
    $email = htmlspecialchars($_POST['email']);
    $source = htmlspecialchars($_POST['select-where']);

    $mail = new PHPMailer(true);
    try {
        // Server settings for Gmail SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'your-gmail@gmail.com';  // Your Gmail address
        $mail->Password = 'your-app-password';     // Your Gmail password or App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('your-gmail@gmail.com', 'Website Form');  // Same Gmail as above
        $mail->addAddress('your-gmail@gmail.com');  // Your Gmail to receive the email
        $mail->addReplyTo($email, $fullName);

        // Content
        $mail->isHTML(false);  // Plain text email
        $mail->Subject = 'New Sign-Up Form Submission';
        $mail->Body = "New submission received:\n\nFull Name: $fullName\nEmail: $email\nHeard from: $source";

        $mail->send();
        header("Location: thank-you.html");
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>