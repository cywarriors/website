<?php
session_start();
if (!isset($_SESSION['select_plan_id']) || empty($_SESSION['select_plan_id'])) {
    echo '<script>window.location.href = "logout.php";</script>';
    exit;
}
include('includes/header.php');

require_once('includes/config.php');

$errors = array(); // Array to store error messages

// Verify the token before processing OTP
if (isset($_GET['token']) && isset($_GET['expiry'])) {
    $token = $_GET['token'];
    $expiryTime = $_GET['expiry'];
    $tempIdentifier = $_SESSION['temp_identifier'];

    // Validate the token based on your criteria (e.g., time-based)
    $validToken = md5($tempIdentifier . $expiryTime) == $token && $expiryTime > time();

    if ($validToken) {
        // Token is valid, continue processing OTP
        if (isset($_POST['verify'])) {
            $enteredOTP = $_POST['otp'];
            $tempIdentifier = $_SESSION['temp_identifier'];
            $storedOTP = $_SESSION['temp_otp'];

            if ($enteredOTP == $storedOTP) {
                // OTP is correct, proceed to save user data
                $fname = $_SESSION['temp_fname'];
                $lname = $_SESSION['temp_lname'];
                $email = $_SESSION['temp_email'];
                $password = $_SESSION['temp_password'];
                $contact = $_SESSION['temp_contact'];
                $hashed_password = md5($password);

                // Save user data in the database
                $saveUserData = mysqli_query($con, "INSERT INTO users (fname, lname, email, password, contactno) VALUES ('$fname', '$lname', '$email', '$hashed_password', '$contact')");

                if ($saveUserData) {
                    // Fetch the user ID after inserting the data
                    $getUserIDQuery = mysqli_query($con, "SELECT id FROM users WHERE email = '$email'");
                    $userData = mysqli_fetch_assoc($getUserIDQuery);

                    if ($userData) {
                        $userid = $userData['id'];
                        // Set the user ID in the session
                        $_SESSION['id'] = $userid;
                        header("Location: plan_order.php");
                        exit();
                    } else {
                        $errors[] = "Failed to retrieve user ID.";
                    }
                } else {
                    $errors[] = "Failed to save user data.";
                }
            } else {
                $errors[] = "Incorrect OTP. Please try again.";
            }
        }
    } else {
        $errors[] = "Invalid or expired token.";
    }
} else {
    echo '<script>window.location.href = "logout.php";</script>';
}

?>

<div class="otpform">
    <div class="otpforminner">
        <h2>Enter OTP</h2>
        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo $error; ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="post" action="">
            <input type="text" id="otp" name="otp" placeholder="Enter OTP" required>
            <button type="submit" name="verify">Verify OTP</button>
        </form>
        <p class="alertpara">Please check your email for OTP.</p>
    </div>
</div>

<?php include('includes/footer.php'); ?>


