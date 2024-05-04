<?php
session_start();

// Completely destroy the session
session_destroy();

// Redirect to index.php or any other desired page
 echo '<script>window.location.href = "login.php";</script>';
exit;
?>
