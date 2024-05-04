<?php
include('includes/header.php');
include('includes/config.php');

// Initialize the message variable
$message = '';

if(isset($_POST['send'])){
    $femail = $_POST['femail'];
    $row1 = mysqli_query($con, "SELECT email, fname, id FROM users WHERE email='$femail'");
    $row2 = mysqli_fetch_array($row1);
    
    if($row2 > 0) {
        $toemail = $row2['email'];
        $fname = $row2['fname'];
        $subject = "Password Reset Request";

        // Generate a unique token for the password reset link
        $token = uniqid();

        // Store the token in the database along with the user's email and an expiry timestamp
        // (This part is not implemented in this example, but you would typically do this)

        // Construct the password reset link with the token
        $reset_link = "https://cyberwarriors.me/reset_password?token=$token&user_id={$row2['id']}";
        // Create the email message
        $message = "Dear $fname,<br><br>";
        $message .= "We received a request to reset your password. ";
        $message .= "If you did not make this request, you can ignore this email.<br><br>";
        $message .= "To reset your password, click on the following link:<br>";
        $message .= "<a href='$reset_link'>$reset_link</a>";

        // Set additional headers
        $headers = 'From: account@cyberwarriors.me' . "\r\n" .
                   'Reply-To: account@cyberwarriors.me' . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();
        
        // Set content type
        $headers .= "Content-Type: text/html; charset=UTF-8";

        // Send the email
        if(mail($toemail, $subject, $message, $headers)) {
            $message = "<div class='alert alert-success' role='alert'>An email with instructions to reset your password has been sent to your email address.</div>";
        } else {
            $message = "<div class='alert alert-danger' role='alert'>Message could not be sent. Please try again later.</div>";
        }
    } else {
        $message = "<div class='alert alert-danger' role='alert'>Email not registered with us.</div>";   
    }
}
?>

<!DOCTYPE html>
<html>
<?php include_once('includes/header.php');?>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header">                                        
                                        <hr />
                                        <h3 class="text-center font-weight-light my-4">Password Recovery</h3>
                                    </div>
                                    <div class="card-body">
                                        <?php echo $message; ?> <!-- Display message here -->
                                        <div class="small mb-3 text-muted">Enter your email address and we will send you the password to your email</div>
                                        <form method="post">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="femail" type="email" placeholder="name@example.com" required />
                                                <label for="inputEmail">Email address</label>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                                <a class="small" href="login.php">Return to login</a>
                                                <button class="btn btn-primary" type="submit" name="send">Reset Password</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="card-footer text-center py-3">
                                        <div class="small"><a href="signup.php">Need an account? Sign up!</a></div>
                                        <div class="small"><a href="index.php">Back to Home</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <?php include('includes/footer.php');?>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
