<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate reCAPTCHA
    $recaptcha_secret = "6Ld0U6EpAAAAAEpF1UVgJR7UhyMHrETvt5TXLpn6"; // Replace with your reCAPTCHA secret key
    $recaptcha_response = $_POST['g-recaptcha-response'];

    // Verify reCAPTCHA response
    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_data = array(
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    );

    $recaptcha_options = array(
        'http' => array(
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($recaptcha_data)
        )
    );

    $recaptcha_context = stream_context_create($recaptcha_options);
    $recaptcha_result = file_get_contents($recaptcha_url, false, $recaptcha_context);
    $recaptcha_response_data = json_decode($recaptcha_result, true);

    if (!$recaptcha_response_data['success']) {
        // If reCAPTCHA verification failed
        echo "reCAPTCHA verification failed.";
        exit;
    }

    // If reCAPTCHA verification successful, proceed to send email
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Email content
    $to = "account@cyberwarriors.me";
    $email_subject = "$subject";
    $email_body = "You have received a new message from the user $name.\n" .
        "Email Address: $email\n" .
        "Message:\n$message";

    // Additional headers
    $headers = "From: $name <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "X-Mailer: PHP/" . phpversion();

    // Send email
    if (mail($to, $email_subject, $email_body, $headers)) {
        echo "Your message has been sent successfully.";
    } else {
        echo "Failed to send the message.";
    }
} else {
    echo "Invalid request";
}
?>

