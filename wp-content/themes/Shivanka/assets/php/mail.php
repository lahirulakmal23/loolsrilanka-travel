
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mail_to = "example@yourdomain.com";
    $subject = trim($_POST["subject"]);
    $yourname = trim($_POST["yourname"]);
    $email = trim($_POST["email"]);
    $message = trim($_POST["message"]);

    $content = "Name: $yourname\nEmail: $email\nMessage:\n$message\n";
    $headers = "From: $yourname <$email>";

    $success = mail($mail_to, $subject, $content, $headers);

    $code = $success ? '200' : '500';
    header("Location: ../../contact.html?code=$code");
    exit;
} else {
    header("Location: ../../contact.html?code=403");
    exit;
}
?>