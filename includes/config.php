<?php

define('DB_SERVER','localhost');

define('DB_USER','cyberwarriors');

define('DB_PASS' ,'%Nwaq7tu1[kD');

define('DB_NAME', 'cyberwarriors');

$con = mysqli_connect(DB_SERVER,DB_USER,DB_PASS,DB_NAME);



// Check connection

if (mysqli_connect_errno())

{

echo "Failed to connect to MySQL: " . mysqli_connect_error();

 }
//Razorpay keys
define('RAZORPAY_KEY_ID', 'rzp_live_ifcJypB2Eb3OuX');
define('RAZORPAY_KEY_SECRET', 'Cm3fkGB1b1ashGMvwm6TUpAj');

// define('RAZORPAY_KEY_ID', 'rzp_test_WWX5DhmUIlacTd');
// define('RAZORPAY_KEY_SECRET', 'lkamTaIIaob90sVDbzve2tty');

function updateTransactionStatus($con) {
    // Use a single SQL UPDATE statement to update the status based on the conditions
    $sql = "UPDATE transactions SET status = 'Renew' WHERE created_at + INTERVAL duration DAY <= NOW()";
    
    $result = mysqli_query($con, $sql);

    // if ($result === false) {
    //     echo "Error updating statuses: " . mysqli_error($con);
    // } else {
    //     $affectedRows = mysqli_affected_rows($con);
    //     echo "Successfully updated $affectedRows transactions to Renew.\n";
    // }
}

// Assuming $con is properly initialized elsewhere in your code

updateTransactionStatus($con);


?>





