<?php
require '/PHPMailer.php'; // Replace 'path/to' with the actual path to PHPMailer library

if (empty($_POST['name']) || empty($_POST['subject']) || empty($_POST['message']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
  http_response_code(400); // Bad Request
  exit();
}

$name = strip_tags(htmlspecialchars($_POST['name']));
$email = strip_tags(htmlspecialchars($_POST['email']));
$m_subject = strip_tags(htmlspecialchars($_POST['subject']));
$message = strip_tags(htmlspecialchars($_POST['message']));

$to = "aqibshoukatweb@gmail.com"; // Change this email to your actual email address //
$subject = "$m_subject: $name";
$body = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email\n\nSubject: $m_subject\n\nMessage: $message";

$mail = new PHPMailer();
$mail->setFrom($email, $name);
$mail->addAddress($to);
$mail->Subject = $subject;
$mail->Body = $body;

try {
  if (!$mail->send()) {
    throw new Exception('Failed to send email. Please try again later.');
  }
} catch (Exception $e) {
  http_response_code(500); // Internal Server Error
  echo $e->getMessage();
}
?>
