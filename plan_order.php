<?php
session_start();
include_once('includes/config.php');
$costumer_id = $_SESSION['id'];
$error_messages = array(); // Array to store error messages

// Check if plan ID is available via GET parameters
if (isset($_GET['planid']) && !empty($_GET['planid'])) {    
  $select_plan_id = $_GET['planid'];
} else {    
    if (isset($_SESSION['select_plan_id']) && !empty($_SESSION['select_plan_id'])) {
        $select_plan_id = $_SESSION['select_plan_id'];
    } else {
        $error_messages[] = "Plan ID is missing.";
    }  
} 

// Check if session variables are set and not empty
if (!isset($_SESSION['id'])  || empty($_SESSION['id']) || empty($select_plan_id)) {
    $error_messages[] = "Session ID or Plan ID is empty.";
}

include('includes/header.php');

$transaction_query = mysqli_query($con, "SELECT * FROM transactions WHERE user_id = $costumer_id AND product_id = $select_plan_id");
if ($transaction_query && mysqli_num_rows($transaction_query) > 0) {        
    $transaction_row = mysqli_fetch_assoc($transaction_query);
    $plan_status = $transaction_row['status'];         
    if ($plan_status == 'authorized') {
        $error_messages[] = "You have already purchased this plan.";
    }
}

// Razorpay test API credentials
$keyId = RAZORPAY_KEY_ID;
$keySecret = RAZORPAY_KEY_SECRET;

$query = mysqli_query($con, "SELECT * FROM plans WHERE id = $select_plan_id");
if ($query) {
    $row = mysqli_fetch_assoc($query);
}

// Fetch user details from the database
$results = mysqli_query($con, "SELECT * FROM users WHERE id = $costumer_id");
if ($results) {
    $rows = mysqli_fetch_assoc($results);
    $fname = $rows['fname'];
    $lname = $rows['lname'];
    $email = $rows['email'];
} else {
    // If user details are not found, fallback to session data
    $fname = $_SESSION['temp_fname'];
    $lname = $_SESSION['temp_lname'];
    $email = $_SESSION['temp_email'];   
}
?>

<div class="payment-integration">
    <div class="payment-inner">
        <div class="container mt-3" style="width: 50%;">
            <h2>Payment for Membership</h2>
            <?php if (!empty($error_messages)): ?>
                <div class="alert alert-danger">
                    <ul>
                        <?php foreach ($error_messages as $error_message): ?>
                            <li><?php echo $error_message; ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php else: ?>
                <form action="#">
                    <div class="mb-3 mt-3">
                        <label for="email">Plan Name:</label>
                        <input type="text" class="form-control" id="name" placeholder="Enter Plan Name" readonly name="payee_name" value="<?php echo $row['name']; ?>">
                    </div>
                    <div class="mb-3 mt-3">
                        <label for="email">Plan Durations:</label>
                        <input type="number" class="form-control" id="name" placeholder="Enter Payee Name" readonly name="plan_duration" value="<?php echo $row['duration']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="pwd"> Plan Amount:</label>
                        <input type="number" class="form-control" id="amount" placeholder="Enter Amount" readonly name="amount" value="<?php echo $row['price'] * 12; ?>">
                    </div>
                    <!-- Hidden form fields -->
                    <input type="hidden" name="plan_id" value="<?php echo $select_plan_id; ?>">
                    <button type="button" class="btn btn-primary" id="rzp-button1">Pay Now</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#rzp-button1').click(function(e) {
            e.preventDefault();
            var name = '<?php echo $fname . ' ' . $lname; ?>';
            var email = '<?php echo $email; ?>';
            var amount = '<?php echo $row['price'] * 12; ?>';
            var plan_id = '<?php echo $select_plan_id; ?>';
            var duration = '<?php echo $row['duration']; ?>';           
            var options = {
                "key": "<?php echo $keyId; ?>",
                "amount": amount * 100 ,
                "currency": "INR",
                "name": name,
                "description": "Payment for Plan #" + plan_id,                
                "image": "https://cyberwarriors.me/assets/img/cyberLogoFinl.png",
                "handler": function(response) {
                    var razorpay_payment_id = response.razorpay_payment_id;
                    $.ajax({
                        url: 'payment-process',
                        type: 'POST',
                        data: {
                            razorpay_payment_id: razorpay_payment_id,
                            amount: amount,
                            email: email,
                            plan_id: plan_id, 
                            duration: duration
                        },
                        success: function(response) {                      
                                window.location.href = "success";
                        },
                        error: function(xhr, status, error) {
                            console.error("AJAX Error: " + error);
                           window.location.href = "cancel";
                        }
                    });
                },
                "prefill": {
                    "name": name,
                    "email": email
                },
                "theme": {
                    "color": "#3399cc"
                }
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        });
    });
</script>
<?php include('includes/footer.php');?>
