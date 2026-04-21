<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // Sanitize input
    function clean($data) {
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }

    $name = clean($_POST["name"] ?? '');
    $email = clean($_POST["email"] ?? '');
    $message = clean($_POST["message"] ?? '');

    $errors = [];

    // ===== VALIDATION =====
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (empty($email)) {
        $errors[] = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }

    if (empty($message)) {
        $errors[] = "Message is required";
    }

    // ===== ERROR HANDLING =====
    if (!empty($errors)) {
        echo "<h2>Form Errors</h2><ul>";
        foreach ($errors as $error) {
            echo "<li>$error</li>";
        }
        echo "</ul><a href='index.php'>Go Back</a>";
        exit;
    }

    // ===== EMAIL SENDING =====
    $to = "your@email.com"; // 🔁 replace with your email
    $subject = "New Contact Form Message from QuickPOS";

    $body = "You received a new message:\n\n";
    $body .= "Name: $name\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message\n";

    $headers = "From: $email\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Send email
    if (mail($to, $subject, $body, $headers)) {
        header("Location: thank-you.html");
        exit;
    } else {
        echo "Something went wrong. Please try again.";
        exit;
    }

} else {
    header("Location: index.php");
    exit;
}
?>  