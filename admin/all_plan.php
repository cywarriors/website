<?php session_start();

include_once('../includes/config.php');

if (strlen($_SESSION['adminid']==0)) {

  header('location:logout.php');

  } else{


   ?>

<!DOCTYPE html>

<html lang="en">

    <head>

        <meta charset="utf-8" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

        <meta name="description" content="" />

        <meta name="author" content="" />

        <title>All Plans</title>

        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

        <link href="../css/styles.css" rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>



    </head>

    <body class="sb-nav-fixed">

      <?php include_once('includes/navbar.php');?>

        <div id="layoutSidenav">

         <?php include_once('includes/sidebar.php');?>

            <div id="layoutSidenav_content">

                <main>

                    <div class="container-fluid px-4">

                        <h1 class="mt-4">All Plans</h1>

                        <ol class="breadcrumb mb-4">

                            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>

                            <li class="breadcrumb-item active">All Plans</li>

                        </ol>

            

                        <div class="card mb-4">

                            <div class="card-header">

                                <i class="fas fa-table me-1"></i>

                                Registered All Plans                   

                            </div>

                            <div class="card-body">                                

                                <table id="datatablesSimple">

                                    <thead>

                                        <tr>

                                  <th>Sno.</th>

                                  <th>Plan Name</th>

                                  <th> Plan Price</th>

                                  <th>Transcation Id</th>

                                  <th>Contact Number</th>

                                  <th>User name</th>

                                  <th>Status</th>

                                  <th>Reg. Date</th>                                 

                                        </tr>

                                    </thead>

                                    <tfoot>

                                        <tr>

                                    <th>Sno.</th>

                                  <th>Plan Name</th>

                                  <th> Plan Price</th>

                                  <th>Transcation Id</th>

                                  <th>Contact Number</th>

                                  <th>User name</th>

                                  <th>Status</th>

                                  <th>Reg. Date</th>                                   
                                   </tr>
                                    </tfoot>
                                    <tbody>

                        <?php  
                            $ret = mysqli_query($con, "SELECT t.*, u.email AS user_email, p.name AS plan_name
                            FROM transactions t
                            INNER JOIN users u ON t.user_id = u.id
                            INNER JOIN plans p ON t.product_id = p.id;");
                              $cnt=1;

                              while($result=mysqli_fetch_array($ret))

                              {?>

                              <tr>

                            <td><?php echo $cnt;?></td>
                            <td><?php echo $result['plan_name'];?></td>
                            <td><?php echo $result['amount'];?></td>
                            <td><?php echo $result['payment_id'];?></td>                            
                            <td><?php echo $result['contact'];?></td>
                            <td><?php echo $result['user_email'];?></td>
                            <td><?php echo $result['status'];?></td>
                            <td><?php echo date('Y-m-d', strtotime($result['created_at'])); ?></td>
                            </tr>

                              <?php $cnt=$cnt+1; }?>

                                      

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                </main>

             <?php include_once('../includes/admin_footer.php'); ?>

            </div>

        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

        <script src="../js/scripts.js"></script>

        <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

        <script src="../js/datatables-simple-demo.js"></script>

    </body>

</html>

<?php } ?>