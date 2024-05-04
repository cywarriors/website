<!DOCTYPE html>

<html lang="en">

<head>
<meta charset="utf-8" />

<meta http-equiv="X-UA-Compatible" content="IE=edge" />

<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

<meta name="description" content="" />

<meta name="author" content="" />

<title>Home | Cyberwarriors</title>

<link href="css/styles.css" rel="stylesheet" />

<link href="assets/img/favicon.png" rel="icon">

<link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">



<!-- Google Fonts -->

<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

<!-- Vendor CSS Files -->

<link href="assets/vendor/aos/aos.css" rel="stylesheet">

<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

<link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

<link href="assets/vendor/boxicons/boxicons.min.css" rel="stylesheet">

<link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">

<link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>



<!-- Template Main CSS File -->

<link href="assets/css/style.css" rel="stylesheet">

<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" crossorigin="anonymous"></script>

</head>

<body>

<!-- ======= Header ======= -->

<?php

$current_page = basename($_SERVER['PHP_SELF']); 

$is_home_page = ($current_page == 'index.php');

$header_class = $is_home_page ? '' : 'back_header';?>



<header id="header" class="header <?php echo $header_class; ?> fixed-top">

<div class="container-fluid container-xl d-flex align-items-center justify-content-between">

<a href="index.php" class="logo d-flex align-items-center">

<?php if($is_home_page) { ?>

 <img src="assets/img/cyberLogoFinl.png" alt="logoImg"> 

 <?php } else{ ?>

 <img src="assets/img/cyberLogoFinlWhite.png" alt="logoImg"> 

 <?php } ?>

<!-- <span>Cyberwarriors</span> -->

</a>

<nav id="navbar" class="navbar">

<ul>

  <li><a class="nav-link scrollto active" href="/">Home</a></li>

  <!-- <li><a class="nav-link scrollto" href="#about">About</a></li> -->

  <li><a class="nav-link scrollto" href="https://cyberwarriors.me/#pricing">Our Plans</a></li> 

  <!-- <li><a class="nav-link scrollto" href="#services">Services</a></li> -->

  <li><a class="nav-link scrollto" href="our-community">Join Our Community</a></li>

  <li><a class="nav-link scrollto" href="https://cyberwarriors.me/#contact">Contact</a></li>

  <li><a class="getstarted scrollto" href="login">Get Protected</a></li>

</ul>

<i class="bi bi-list mobile-nav-toggle"></i>

</nav><!-- .navbar -->

</div>

</header><!-- End Header -->



