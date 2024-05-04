<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate captcha
    $captcha = $_POST['captcha'];
    $captcha_sum = $_POST['captcha_sum'];

    if ($captcha == $captcha_sum) {
        // Captcha is correct, proceed with sending email
        $to = "sachin.kumar@digranknow.com"; // Replace with your email address
        $subject = $_POST['subject'];
        $message = "Name: " . $_POST['name'] . "\n";
        $message .= "Email: " . $_POST['email'] . "\n";
        $message .= "Message: " . $_POST['message'];
        $headers = "From: " . $_POST['email'];

        // Send email
        if (mail($to, $subject, $message, $headers)) {
            // Email sent successfully
            echo json_encode(array("status" => "success", "message" => "Your message has been sent. Thank you!"));
        } else {
            // Failed to send email
            echo json_encode(array("status" => "error", "message" => "Failed to send email. Please try again later."));
        }
    } else {
        // Captcha is incorrect
        echo json_encode(array("status" => "error", "message" => "Incorrect captcha. Please try again."));
    }
} else {
    // Form not submitted
    echo json_encode(array("status" => "error", "message" => "Form not submitted."));
}
?>
