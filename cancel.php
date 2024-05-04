<?php
session_start();
$transid = $_SESSION['transaction_id'];
include('includes/header.php');
include_once('includes/config.php');
if ($transid) { ?>
    <div class="success_page">
        <div class="content">
            <article class="bg-secondary mb-3">
                <div class="card-body text-center">
                    <h4 class="text-white">Your Payment is Cancel Please check and Try again  <br></h4>
                    <br>
                    <p><a class="btn btn-warning" target="_blank" href="index.php">Back to Home Page
                            <i class="fa fa-window-restore"></i></a></p>
                </div>
            </article>
        </div>
    </div>

    <script>
        setTimeout(function () {
            window.location.href = 'welcome.php';
        }, 10000); // 10000 milliseconds = 10 seconds

        // Destroy only the transaction_id session variable after 10 seconds
        setTimeout(function () {
            <?php unset($_SESSION['transaction_id']); ?>
            <?php unset($_SESSION['select_plan_id']); ?>
        }, 10000);
    </script>

<?php } ?>

<?php include('includes/footer.php'); ?>

