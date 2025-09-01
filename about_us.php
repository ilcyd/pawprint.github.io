<?php
include ('includes/header.php');
include ('includes/session.php');
?>

<body class="hold-transition layout-top-nav sidebar-collapse">
 <div class="wrapper">
  <!-- Preloader -->
  <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> -->

  <?php include ('includes/navbar.php'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   <div class="container">
    <!-- Content Header (Page header) -->
    <div class="content">
     <div class="row">
      <div class="col-sm-12">
       <h1>About Us</h1>
       <p>Welcome to Ipil Pet Doctors Veterinary Clinic, your trusted veterinary clinic in Ipil. We are
        dedicated to providing
        high-quality care to your beloved pets and animals in our community.</p>


       <br>

       <h2>Our Mission</h2>
       <p>At Ipil Pet Doctors Veterinary Clinic, our mission is to provide compassionate and comprehensive veterinary
        care. We strive to
        enhance the health and well-being of pets and animals in our rural community through exceptional medical
        services and genuine care.</p>

       <h2>Our Team</h2>
       <p>Our dedicated team of veterinarians and support staff are committed to delivering the best possible care for
        your animals. With years of experience and a love for animals, our team is here to assist with all your
        veterinary needs.</p>

       <h2>Our Services</h2>
       <ul>
        <li>Routine Check-ups and Vaccinations</li>
        <li>Emergency Care</li>
        <li>Surgery and Anesthesia</li>
        <li>Diagnostics and Laboratory Services</li>
       </ul>


      </div><!-- /.col-sm-12 -->
     </div><!-- /.row -->
    </div><!-- /.content -->
   </div><!-- /.container -->
  </div><!-- /.content-wrapper -->

  <?php include ('includes/footer.php'); ?>
  <?php include ('includes/appointment_modal.php'); ?>

 </div><!-- ./wrapper -->

 <?php include ('includes/scripts.php'); ?>
</body>

</html>