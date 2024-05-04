<?php
include('includes/header.php');
include('includes/config.php');

// Initialize variables for error messages and success message
$password_err = $confirm_password_err = '';
$message = '';

// Check if user ID is provided in the URL (assuming user ID is passed via GET parameter)
if(isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $token = $_GET['token'];

    // You may perform additional validation here to ensure the user ID is valid
} else {
    echo "User ID not provided.";
    exit();
}

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate new password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have at least 6 characters.";
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($confirm_password != $_POST["password"])){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if(empty($password_err) && empty($confirm_password_err)){    
        $hashed_password = md5($_POST["password"]); 
        mysqli_query($con, "UPDATE users SET password='$hashed_password' WHERE id='$user_id'");
        
        // Show success message
        $message = "<div class='alert alert-success' role='alert'>Your password has been successfully updated.</div>";
    }
}
?>

<!-- Reset Password Form -->
<div class="container" style="padding-top: 100px;
    padding-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-body">
                    <h3 class="card-title text-center">Reset Your Password</h3>
                    <form action="" method="post">
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" id="password" name="password" required>
                            <span class="invalid-feedback"><?php echo $password_err; ?></span>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" id="confirm_password" name="confirm_password" required>
                            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                        </div>
                        <input type="hidden" name="token" value="<?php echo $token; ?>">
                        <button type="submit" class="btn btn-primary">Reset Password</button>
                    </form>
                    <?php echo $message; ?> <!-- Display success message here -->
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>
