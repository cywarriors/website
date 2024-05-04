<?php 
session_start();
 //include('includes/header.php');
include_once('includes/config.php');
include('includes/admin_header.php'); 
if (strlen($_SESSION['id']==0)) {
header('location:logout.php');
}
?>

<body class="sb-nav-fixed">
    <?php include_once('includes/navbar.php');?>
    <div id="layoutSidenav">
        <?php include_once('includes/sidebar.php');?>
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <?php 
                   $userid = $_SESSION['id'];            
                    $query = mysqli_query($con,"SELECT * FROM users WHERE id='$userid'");
                    while($result = mysqli_fetch_array($query)) {
                    ?>
                    <h1 class="mt-4"><?php echo $result['fname'];?>'s Profile</h1>
                    <div class="card mb-4">
                        <div class="card-body">
                            <a href="edit-profile.php">Edit</a>
                            <table class="table table-bordered">
                                <tr>
                                    <th>First Name</th>
                                    <td><?php echo $result['fname'];?></td>
                                </tr>
                                <tr>
                                    <th>Last Name</th>
                                    <td><?php echo $result['lname'];?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td colspan="3"><?php echo $result['email'];?></td>
                                </tr>
                                <tr>
                                    <th>Contact No.</th>
                                    <td colspan="3"><?php echo $result['contactno'];?></td>
                                </tr>
                                <tr>
                                    <th>Reg. Date</th>
                                    <td colspan="3"><?php echo $result['posting_date'];?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </main>
        </div>
    </div>
    <?php include('includes/admin_footer.php');?>

