<?php
session_start();
include_once('../includes/config.php');

if (strlen($_SESSION['adminid'] == 0)) {
    header('location:logout.php');
} else {
    // Code for Plan Edit
    if (isset($_POST['editPlan'])) {
        $editPlanID = $_GET['planid'];
        $editPlanName = mysqli_real_escape_string($con, $_POST['editPlanName']);
        $editPlanPrice = mysqli_real_escape_string($con, $_POST['editPlanPrice']);
        $editPlanText = mysqli_real_escape_string($con, $_POST['editPlanText']);
        $planduration = mysqli_real_escape_string($con, $_POST['planduration']);

        $query = mysqli_query($con, "UPDATE plans SET name='$editPlanName', price='$editPlanPrice', duration='$planduration', description='$editPlanText' WHERE id='$editPlanID'");

        if ($query) {
            echo "<script>alert('Plan updated successfully.');</script>";
        } else {
            echo "<script>alert('Error updating plan');</script>";
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
                <?php 
$planid=$_GET['planid'];
$query=mysqli_query($con,"select * from plans where id='$planid'");
while($result=mysqli_fetch_array($query))
{?>
    
                <div class="container-fluid px-4">
                     <div class="plantxt">                    
                        <h1 class="mt-4 datacls">Edit Plan</h1> 
                        <a href="manage-plan.php" class="add_plans mt-4">Manage Plans</a>
                    </div>  
                    <div class="card mb-4">
                        <form method="post">
                            <div class="card-body">
                                <table class="table table-bordered">
                                  
                                    <tr>
                                        <th>Plan Name</th>
                                        <td><input class="form-control" id="editPlanName" name="editPlanName" type="text" value="<?php echo $result['name'];?>" required /></td>
                                    </tr>
                                    <tr>
                                        <th>Plan Price</th>
                                        <td><input class="form-control" id="editPlanPrice" name="editPlanPrice" type="number" value="<?php echo $result['price'];?>" min="0" required /></td>
                                    </tr>
                                      <tr>
                                        <th> Plan Duration</th>
                                        <td>
                                   <input class="form-control" id="planduration" name="planduration" type="text" value="<?php echo $result['duration'];?>" required /></td>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Plan Text</th>
                                        <td><textarea class="form-control" id="editPlanText" name="editPlanText" rows="4" required><?php echo $result['description'];?></textarea></td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align:center ;">
                                            <button type="submit" class="btn btn-success btn-block" name="editPlan">Edit Plan</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </main>
        </div>
    </div>
      
<?php include_once('../includes/admin_footer.php'); ?>
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
        CKEDITOR.replace('planText');
</script>
