<?php
session_start();
include_once('includes/config.php');

if (empty($_SESSION['id'])) {
    header('location: logout.php');
    exit; // Ensure that no further code is executed after redirection
}

$userid = $_SESSION['id'];

$query = mysqli_query($con, "SELECT t.*, u.email AS user_email, p.name AS plan_name, u.contactno AS user_contact
                            FROM transactions t
                            INNER JOIN users u ON t.user_id = u.id
                            INNER JOIN plans p ON t.product_id = p.id
                            WHERE t.user_id = '$userid'");

$num_rows = mysqli_num_rows($query); // Count the number of rows returned

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>
</head>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php'); ?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php'); ?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">All Plans</h1>
                    <?php if ($num_rows == 0) : // If no transactions found ?>
                        <div class="text-center">
                            <a href="/" class="btn btn-primary">Purchase Plan</a>
                        </div>
                    <?php else : // If transactions found ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Plan Name</th>
                                            <th>Transactions Id</th>
                                            <th>Price</th>
                                            <th>Email</th>
                                            <th>Contact No.</th>
                                            <th>Status</th>
                                            <th>Reg. Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $rowid = 1;
                                        while ($result = mysqli_fetch_array($query)) { ?>
                                            <tr>
                                                <td><?php echo $rowid++; ?></td>
                                                <td><?php echo $result['plan_name']; ?></td>
                                                <td><?php echo $result['payment_id']; ?></td>
                                                <td><?php echo $result['amount'] * 12; ?></td>
                                                <td><?php echo $result['user_email']; ?></td>
                                                <td><?php echo $result['user_contact']; ?></td>
                                                <td><?php echo $result['status']; ?></td>
                                                <td><?php echo date('Y-m-d', strtotime($result['created_at'])); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </main>
            <?php include('includes/admin_footer.php'); ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
    <script src="assets/demo/chart-area-demo.js"></script>
    <script src="assets/demo/chart-bar-demo.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
    <script src="js/datatables-simple-demo.js"></script>
</body>

</html>