<?php
session_start();

// Check if user is already logged in
if(isset($_SESSION['id'])) {
    header('Location: welcome.php');
    exit;
}

include('includes/header.php');
include_once('includes/config.php');

// Initialize errors array
$errors = array();

// Code for login 
if(isset($_POST['login'])) {
    // Validate user input
    $useremail = isset($_POST['uemail']) ? trim($_POST['uemail']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';
    $captcha_response = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';

    if(empty($useremail)) {
        $errors['uemail'] = "Email is required";
    }

    if(empty($password)) {
        $errors['password'] = "Password is required";
    }

    if(empty($captcha_response)) {
        $errors['captcha'] = "Please complete the CAPTCHA verification.";
    } else {
        // Verify CAPTCHA response
        $secret_key = '6Ld0U6EpAAAAAEpF1UVgJR7UhyMHrETvt5TXLpn6'; // Replace with your reCAPTCHA secret key
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $data = array(
            'secret' => $secret_key,
            'response' => $captcha_response
        );
        $options = array(
            'http' => array (
                'method' => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $response = file_get_contents($url, false, $context);
        $captcha_result = json_decode($response, true);
        if (!$captcha_result['success']) {
            $errors['captcha'] = "CAPTCHA verification failed. Please try again.";
        }
    }

    // Proceed with login if no errors
    if(empty($errors)) {
        // Sanitize user inputs
        $useremail = mysqli_real_escape_string($con, $useremail);
        $hashed_password = md5($password);

        // Query database
        $query = "SELECT id, fname FROM users WHERE email='$useremail' AND password='$hashed_password'";
        $result = mysqli_query($con, $query);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $_SESSION['id'] = $row['id'];
            $_SESSION['name'] = $row['fname'];
            header('Location: welcome.php');
            exit; 
        } else {
            $errors['invalid'] = "Invalid username or password";
        }
    }
}

?>

<body class="bg-updated">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card upd_cards border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h2 align="center">User Login</h2>
                                </div>
                                <div class="card-body">
                                    <form method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control <?php if(isset($errors['uemail'])) echo 'is-invalid'; ?>" name="uemail" type="email" placeholder="name@example.com" required/>
                                            <label for="inputEmail">Email address</label>
                                            <?php if(isset($errors['uemail'])) { ?>
                                                <div class="invalid-feedback"><?php echo $errors['uemail']; ?></div>
                                            <?php } ?>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control <?php if(isset($errors['password'])) echo 'is-invalid'; ?>" name="password" type="password" placeholder="Password" required />
                                            <label for="inputPassword">Password</label>
                                            <?php if(isset($errors['password'])) { ?>
                                                <div class="invalid-feedback"><?php echo $errors['password']; ?></div>
                                            <?php } ?>
                                        </div>
                                         <div class="g-recaptcha" data-sitekey="6Ld0U6EpAAAAAD-_2sovWsVnjXiF8dPxzrFp8PXT"></div>
                                        <?php if(isset($errors['captcha'])) { ?>
                                            <div class="text-danger"><?php echo $errors['captcha']; ?></div>
                                        <?php } ?>
                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="password-recovery.php">Forgot Password?</a>
                                            <button class="btn btn-primary" name="login" type="submit">Login</button>
                                        </div>
                                        <?php if(isset($errors['invalid'])) { ?>
                                            <div class="alert alert-danger mt-3" role="alert"><?php echo $errors['invalid']; ?></div>
                                        <?php } ?>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small d-flex justify-content-between"><a href="signup.php">Need an account? Sign up!</a><a href="index.php">Back to Home</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
 <?php include_once('includes/footer.php');?>

 <?php include_once('includes/footer.php');?>
