<?php
$name = $_POST['name'];
$visitor_email = $_POST['email']; // Corrected spelling from $vistor_email
$subject = $_POST['subject'];
$message = $_POST['message'];

$email_from = 'smarteaglesministries@gmail.com';

$email_subject = 'New Form Submission';

// Corrected variable name in the email body
$email_body = "User Name: $name.\n".
              "User Email: $visitor_email.\n".
              "Subject: $subject.\n".
              "User Message: $message.\n";

$to = "muhammadnuru85@gmail.com";

// Email headers
$headers = "From: $email_from\r\n";
$headers .= "Reply-To: $visitor_email\r\n";

// Send the email
if (mail($to, $email_subject, $email_body, $headers)) {
    header("Location: contact.html");
    exit(); // Make sure to exit after header redirection
} else {
    echo "Email sending failed."; // Optional: for debugging
}
?>
