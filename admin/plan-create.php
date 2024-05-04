<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid'] == 0)) {
    header('location:logout.php');
} else {
    // Code for Plan Addition
    if (isset($_POST['addPlan'])) {
        $planName = mysqli_real_escape_string($con, $_POST['planName']);
        $planPrice = mysqli_real_escape_string($con, $_POST['planPrice']);
        $planText = mysqli_real_escape_string($con, $_POST['planText']);
        $Durations = mysqli_real_escape_string($con, $_POST['Durations']);

        $query = mysqli_query($con, "INSERT INTO plans (name, price ,duration, description) VALUES ('$planName', '$planPrice', $Durations, '$planText')");

        if ($query) {
            echo "<script>alert('Plan added successfully.');</script>";
        } else {
            echo "<script>alert('Error adding plan');</script>";
        }
    }
}
?>
<?php include_once('../includes/admin_header.php'); ?>
<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php');?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php');?>
        <div id="layoutSidenav_content">
            <main>
                
                <div class="container-fluid px-4">
                    <div class="plantxt">                    
                        <h1 class="mt-4 datacls">Add Plan</h1> 
                      <a href="manage-plan.php" class="add_plans mt-4">Manage Plans</a>
                    </div>                    
                    <div class="card mb-4">
                        <form method="post">
                            <div class="card-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <th>Plan Name</th>
                                        <td><input class="form-control" id="planName" name="planName" type="text" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Plan Price</th>
                                        <td><input class="form-control" id="planPrice" name="planPrice" type="number" min="0" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Durations in Days</th>
                                        <td><input class="form-control" id="Durations" name="Durations" type="number" min="0" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Plan Text</th>
                                        <td><textarea class="form-control" id="planText" name="planText" rows="4" required></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:center ;">
                                            <button type="submit" class="btn btn-primary btn-block" name="addPlan">Add Plan</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </main>
            
        </div>
    </div>
    
<?php include_once('../includes/admin_footer.php'); ?>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
        CKEDITOR.replace('planText');
</script>
