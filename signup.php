<?php
session_start();

include_once('includes/header.php');
require_once('includes/config.php');

if (isset($_SESSION['id']) && $_SESSION['id'] != 0) {
    // Redirect to welcome.php
    echo '<script>window.location.href = "welcome.php";</script>';
    exit(); 
}

function generateOTP() {
    return mt_rand(100000, 999999);
}

$plan_id = isset($_GET['planid']) ? $_GET['planid'] : '';

$errors = array(); // Array to store errors

if (isset($_POST['submit_data'])) {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirmpassword'];
    $contact = $_POST['contact'];
    $select_plan_id = $_POST['all_plans'];

    // Validate form data
    if (empty($fname) || empty($lname) || empty($email) || empty($password) || empty($confirm_password) || empty($contact) || empty($select_plan_id)) {
        $errors[] = "All fields are required.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }

    if (!preg_match("/^[0-9]{10}$/", $contact)) {
        $errors[] = "Invalid contact number format. Please enter 10 numeric characters only.";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}$/", $password)) {
        $errors[] = "Password must be at least 6 characters long and contain at least one number, one uppercase letter, and one lowercase letter.";
    }

    // Check for duplicate email
    $checkDuplicateEmail = mysqli_prepare($con, "SELECT id FROM users WHERE email = ?");
    mysqli_stmt_bind_param($checkDuplicateEmail, "s", $email);
    mysqli_stmt_execute($checkDuplicateEmail);
    mysqli_stmt_store_result($checkDuplicateEmail);

    if (mysqli_stmt_num_rows($checkDuplicateEmail) > 0) {
        $errors[] = "Email already exists. Please use a different email.";
    }

    if (empty($errors)) {
        // Generate a temporary unique identifier
        $tempIdentifier = uniqid();

        // Generate OTP
        $otp = generateOTP();
        $_SESSION['temp_identifier'] = $tempIdentifier;
        $_SESSION['temp_otp'] = $otp;
        $_SESSION['temp_fname'] = $fname;
        $_SESSION['temp_lname'] = $lname;
        $_SESSION['temp_email'] = $email;
        $_SESSION['temp_password'] = $password;
        $_SESSION['temp_contact'] = $contact;
        $_SESSION['select_plan_id'] = $select_plan_id;        
        $expiryTime = time() + (5 * 60);
        $token = md5($tempIdentifier . $expiryTime);

        // Include the token and expiry time in the URL
        $url = "otpverify.php?token=$token&expiry=$expiryTime";
        // Send the email
        $to = $email;
        $subject = "Verification OTP for Registration";
        $message = "Your OTP for registration is: $otp. Use the following link to enter the OTP: $url";
        $headers = "From: account@cyberwarriors.me";

        if (mail($to, $subject, $message, $headers)) {
            // Redirect to OTP verification page
            header("Location: $url");
            exit();
        } else {
            $errors[] = "Failed to send OTP. Please try again later.";
        }
    }
}
?>

<body class="bg-updated">

    <div id="layoutAuthentication">

        <div id="layoutAuthentication_content">

            <main>

                <div class="container mb-5">

                    <div class="row justify-content-center">

                        <div class="col-lg-7">

                            <div class="card border-0 rounded-lg mt-5 upd_cards">

                                <div class="card-header">

                                    
                                    <h3 class="text-center font-weight-light my-4">Create Account</h3>

                                </div>

                                <div class="card-body">

                                    <form method="post" name="signup">

                                        <!-- Error messages -->
                                        <?php
                                        if (!empty($errors)) {
                                            echo '<div class="alert alert-danger" role="alert">';
                                            foreach ($errors as $error) {
                                                echo "<p>$error</p>";
                                            }
                                            echo '</div>';
                                        }
                                        ?>

                                        <div class="row mb-3">

                                            <div class="col-md-6">

                                                <div class="form-floating mb-3 mb-md-0">

                                                    <input class="form-control" id="fname" name="fname" type="text" placeholder="Enter your first name" required />

                                                    <label for="inputFirstName">First name</label>

                                                </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-floating">

                                                    <input class="form-control" id="lname" name="lname" type="text" placeholder="Enter your last name" required />

                                                    <label for="inputLastName">Last name</label>

                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-floating mb-3">

                                            <input class="form-control" id="email" name="email" type="email" placeholder="account@cyberwarriors.me" required />

                                            <label for="inputEmail">Email address</label>

                                        </div>

                                        <div class="form-floating mb-3">

                                            <input class="form-control" id="contact" name="contact" type="text" placeholder="1234567890" required pattern="[0-9]{10}" title="10 numeric characters only"  maxlength="10" required />

                                            <label for="inputcontact">Contact Number</label>

                                        </div>



                                        <div class="form-floating mb-3">

                                        <select name="all_plans" required style="padding: 1rem 0.75rem; width: 100%;">

                                        <option value="">Select Plan</option>

                                        <?php                                                        

                                        $query = mysqli_query($con, "SELECT * FROM plans");                                   

                                        while ($row = mysqli_fetch_assoc($query)) { ?>

                                        <option value="<?php echo $row['id']; ?>" <?php if ($row['id'] == $plan_id) echo 'selected'; ?>><?php echo $row['name']; ?></option>

                                        <?php    }      ?>

                                        </select>                                           

                                        </div>
                                        <div class="row mb-3">

                                            <div class="col-md-6">

                                                <div class="form-floating mb-3 mb-md-0">

                                                    <input class="form-control" id="password" name="password" type="password" placeholder="Create a password" required/>

                                                    <label for ="inputPassword">Password</label>
                                                      </div>

                                            </div>

                                            <div class="col-md-6">

                                                <div class="form-floating mb-3 mb-md-0">

                                                    <input class="form-control" id="confirmpassword" name="confirmpassword" type="password" placeholder="Confirm password" required />

                                                    <label for="inputPasswordConfirm">Confirm Password</label>

                                                </div>

                                            </div>

                                        </div>

                                        <!-- reCAPTCHA -->
                                        <div class="mb-3">
                                            <div class="g-recaptcha" data-sitekey="6Ld0U6EpAAAAAD-_2sovWsVnjXiF8dPxzrFp8PXT"></div>
                                            <?php if(isset($errors['captcha'])) { ?>
                                                <div class="text-danger"><?php echo $errors['captcha']; ?></div>
                                            <?php } ?>
                                        </div>

                                        <div class="mt-4 mb-0">

                                            <div class="d-grid"><button type="submit" class="btn m-auto btn-primary btn-block" name="submit_data">Create Account</button></div>

                                        </div>

                                    </form>

                                </div>

                                <div class="card-footer text-center py-3">

                                    <div class="small d-flex justify-content-between"><a href="login.php" >Have an account? Go to login</a><a href="index.php">Back to Home</a></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

<?php include_once('includes/footer.php');?>