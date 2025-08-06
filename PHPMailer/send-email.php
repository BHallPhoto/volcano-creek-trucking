<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require __DIR__ . '/src/Exception.php';
require __DIR__ . '/src/PHPMailer.php';
require __DIR__ . '/src/SMTP.php';

$name = htmlspecialchars($_POST['name'] ?? '');
$email = htmlspecialchars($_POST['email'] ?? '');
$message = nl2br(htmlspecialchars($_POST['message'] ?? ''));

if (empty($name) || empty($email) || empty($message)) {
    exit('All fields are required.');
}

try {
    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;
    $mail->Debugoutput = 'html';
    $mail->Host = 'smtp.office365.com';
    $mail->Port = 465;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->SMTPAuth = true;
    $mail->Username = 'theslydingo@outlook.com';
    $mail->Password = 'Buzz01251960zip';

    $mail->setFrom('careers@volcanocreekenterprises.com', 'Volcano Creek Messages');
    $mail->addReplyTo('careers@volcanocreekenterprises.com', 'Volcano Creek');
    $mail->addAddress('bristolhall@gmail.com', 'Bristol Hall');
    $mail->Subject = "New Contact Form Message from $name";
    $mail->isHTML(true);
    $mail->Body    = "
        <h2>Contact Form Submission</h2>
        <p><strong>Name:</strong> $name</p>
        <p><strong>Email:</strong> $email</p>
        <p><strong>Message:</strong><br>$message</p>
    ";
    $mail->AltBody = "Name: $name\nEmail: $email\nMessage:\n" . $_POST['message'];

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
