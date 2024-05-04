<?php
session_start();
$transid = $_SESSION['transaction_id'];
include('includes/header.php');
include_once('includes/config.php');
 if ($transid) { ?>
    <div class="success_page">
        <div class="content">
            <article class=" mb-3">
                <div class="card-body text-center">
                    <h4 class="">Your Payment is Successfully  <br></h4>
                    <br>
                    <p><a class="btn" target="_blank" href="index.php">Back to Home Page
                    <i class="fa fa-home" aria-hidden="true"></i></a></p>
                </div>
            </article>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = 'welcome.php';
        }, 1000); // 10000 milliseconds = 10 seconds

        // Destroy only the transaction_id session variable after 10 seconds
        setTimeout(function () {
            <?php unset($_SESSION['transaction_id']); ?>
            <?php unset($_SESSION['select_plan_id']); ?>
        },1000 ); /*  */
    </script>

<?php } ?>

<?php include('includes/footer.php'); ?>

