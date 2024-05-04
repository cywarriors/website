<?php
session_start();

// Include configuration and header files
include_once('includes/config.php');
include('includes/header.php');

// Function to send email
function sendEmail($to, $subject, $message) {
    $headers = 'From: account@cyberwarriors.me' . "\r\n" .
               'Reply-To: account@cyberwarriors.me' . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    return mail($to, $subject, $message, $headers);
}

// Check if session and POST data are set
if (!isset($_SESSION['id']) || !isset($_POST['plan_id']) || empty($_SESSION['id']) || empty($_POST['plan_id'])) {
    echo json_encode(array('msg' => 'Error: Session or POST data not set', 'status' => false));
    exit;
}

// Extract POST data
$payment_id = $_POST['razorpay_payment_id'];
$amount = $_POST['amount'];
$plan_id = $_POST['plan_id'];
$user_id = $_SESSION['id'];
$duration = $_POST['duration'];
$uemail = $_POST['email'];

// Initialize response array
$result = array();

// Initialize cURL session
$curl = curl_init();

// Set cURL options
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.razorpay.com/v1/payments/' . $payment_id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
        'Authorization: Basic ' . base64_encode(RAZORPAY_KEY_ID . ':' . RAZORPAY_KEY_SECRET)
    ),
));

// Execute cURL request and capture the response
$response = curl_exec($curl);

// Check if cURL request was successful
if ($response === false) {
    $result = array('msg' => 'Error: Failed to fetch payment status', 'status' => false);
} else {
    // Decode the JSON response
    $responseData = json_decode($response, true);

    // Check if decoding was successful and status exists
    if ($responseData && isset($responseData['status'])) {
        // Access the payment status from the decoded response
        $paymentStatus = $responseData['status'];
        $contact = $responseData['contact'];

        // Check if the transaction already exists in the database
        $transaction_query = mysqli_query($con, "SELECT * FROM transactions WHERE user_id = $user_id AND product_id = $plan_id");
        if ($transaction_query && mysqli_num_rows($transaction_query) > 0) {
            $transaction_row = mysqli_fetch_assoc($transaction_query);
            $transaction_id = $transaction_row['id'];

            // Prepare the SQL query to update transaction
            $update_sql = "UPDATE transactions 
                           SET payment_id = '$payment_id', 
                               amount = '$amount', 
                               status = '$paymentStatus', 
                               contact = '$contact', 
                               duration = '$duration' 
                           WHERE id = $transaction_id";

            // Execute the SQL query to update transaction
            if (mysqli_query($con, $update_sql)) {
                $result = array('msg' => 'Payment details successfully updated', 'status' => true);
                $_SESSION['transaction_id'] = $payment_id;
                // Send email to user
                $email_sent = sendEmail($uemail, 'Payment Update', "Your payment details have been successfully updated.\n\nPlan Amount: $amount\nDuration: $duration\nTransaction Status: $paymentStatus");
                if (!$email_sent) {
                    // Email sending failed
                    error_log("Failed to send email to: $uemail");
                }
            } else {
                $result = array('msg' => 'Error: Unable to update transaction in the database', 'status' => false);
            }
        } else {
            // Prepare the SQL query to insert transaction
            $insert_sql = "INSERT INTO transactions (user_id, payment_id, amount, product_id, status, contact, duration) 
                           VALUES ('$user_id', '$payment_id', '$amount', '$plan_id', '$paymentStatus', '$contact', '$duration')";

            $_SESSION['transaction_id'] = $payment_id;

            // Execute the SQL query to insert transaction
            if (mysqli_query($con, $insert_sql)) {
                $result = array('msg' => 'Payment successfully credited', 'status' => true);
                // Send email to user
                $email_sent = sendEmail($uemail, 'Payment Success', "Your payment was successful.\n\nPlan Amount: $amount*12\nDuration: $duration\nTransaction Status: $paymentStatus");
                if (!$email_sent) {
                    // Email sending failed
                    error_log("Failed to send email to: $uemail");
                }
            } else {
                $result = array('msg' => 'Error: Unable to insert transaction into the database', 'status' => false);
            }
        }
    } else {
        $result = array('msg' => 'Error: Unable to retrieve payment status from response', 'status' => false);
    }
}

// Close cURL session
curl_close($curl);

// Echo JSON response
echo json_encode($result);

// Include footer file
include('includes/footer.php');
?>
