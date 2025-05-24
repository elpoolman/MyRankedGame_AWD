<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

function sendWelcomeEmail(string $toEmail, string $toName) {
    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'myrankedgame@gmail.com';        // Your Gmail address
        $mail->Password   = 'sfvufjfgpqbuampv';              // App-specific password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     // Use SSL/TLS
        $mail->Port       = 465;

        // Email headers
        $mail->setFrom('myrankedgame@gmail.com', 'MyRankedGame');
        $mail->addAddress($toEmail, $toName);

        // Email content
        $mail->isHTML(true);
        $mail->Subject = 'Account created in MyRankedGame';
        $mail->Body    = '
            <h2>Welcome to MyRankedGame!</h2>
            <p>We are excited to have you with us.</p>
            <p>Enjoy the experience and community!</p>
        ';

        $mail->send();
        echo "<p>Welcome email sent successfully.</p>";
    } catch (Exception $e) {
        echo "<p>Could not send email. Mailer Error: {$mail->ErrorInfo}</p>";
    }
}

// Example usage
sendWelcomeEmail('recipient@example.com', 'John Doe');
?>
