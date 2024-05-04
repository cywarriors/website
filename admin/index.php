<?php 

session_start(); 

include_once('../includes/admin_header.php');

include_once('../includes/config.php');

 $extra = "dashboard.php";

if(isset($_SESSION['adminid'])) {

echo "<script>window.location.href='".$extra."'</script>";

}

// Code for login 

if(isset($_POST['login'])) {

    $adminusername = $_POST['username'];

    $pass = md5($_POST['password']);

    

    $ret = mysqli_query($con, "SELECT * FROM admin WHERE username='$adminusername' and password='$pass'");

    $num = mysqli_fetch_array($ret);

    

    if($num > 0) {

        $_SESSION['login'] = $_POST['username'];

        $_SESSION['adminid'] = $num['id'];

        echo "<script>window.location.href='".$extra."'</script>";

        exit();

    } else {

        echo "<script>alert('Invalid username or password');</script>";

        $extra = "index.php";

        echo "<script>window.location.href='".$extra."'</script>";

        exit();

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

                            <div class="card upd_cards  rounded-lg mt-5">

                                <div class="card-header">

                                    <h2 align="center">Admin Login</h2>

                                   

                                    

                                </div>

                                <div class="card-body">

                                    <form method="post">

                                        <div class="form-floating mb-3">

                                            <input class="form-control" name="username" type="text" placeholder="Username" required/>

                                            <label for="inputEmail">Username</label>

                                        </div>

                                        <div class="form-floating mb-3">

                                            <input class="form-control" name="password" type="password" placeholder="Password" required />

                                            <label for="inputPassword">Password</label>

                                        </div>

                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">

                                            <a class="small" href="https://cyberwarriors.me/password-recovery">Forgot Password?</a>

                                            <button class="btn btn-primary" name="login" type="submit">Login</button>

                                        </div>

                                    </form>

                                </div>

                                <div class="card-footer text-center py-3">

                                    <div class="small"><a href="../index.php">Back to Home Page</a></div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </main>

        </div>

    </div>

<?php include_once('../includes/admin_footer.php'); ?>

