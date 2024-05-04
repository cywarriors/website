<?php

session_start();

$userid = $_SESSION['id'];

include_once('includes/header.php');

include_once('includes/config.php');

?>

<div class="container text-center" id="error">
  <svg height="100" width="100">
    <polygon points="50,25 17,80 82,80" stroke-linejoin="round" style="fill:none;stroke:#ff8a00;stroke-width:8" />
    <text x="42" y="74" fill="#ff8a00" font-family="sans-serif" font-weight="900" font-size="42px">!</text>
  </svg>
 <div class="row">
    <div class="col-md-12">
      <div class="main-icon text-warning"><span class="uxicon uxicon-alert"></span></div>
        <h1>File not found (404 error)</h1>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 col-md-push-3">
      <p class="lead">If you think what you're looking for should be here, please contact the site owner.</p>
    </div>
  </div>
</div>

<?php include_once('includes/footer.php');?>

<style type="text/css">
body {
  background-color: #eee;
}



#error {  
  margin-top: 177px;

}

#error .row:before, .row:after {
  display: table;
  content: " ";
}

#error .col-md-6 {
  width: 50%;
}

#error .col-md-push-3 {
  margin-left: 25%;
}

h1 {
  font-size: 48px;
  font-weight: 300;
  margin: 0 0 20px 0;
}

#error .lead {
  font-size: 21px;
  font-weight: 200;
  margin-bottom: 20px;
}


</style>


