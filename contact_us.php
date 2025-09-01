<?php
include ('includes/session.php');
include ('includes/header.php');
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
              <h1>Contact Us</h1>
              <p>Feel free to get in touch with us. We are here to assist you with any questions or concerns you may
                have.</p>
              <?php if (isset($_SESSION['user'])): ?>

                <div class="row">
                  <div class="col-md-6">
                    <h2>Contact Information</h2>
                    <address>
                      <strong><?php echo "Ipil Pet Doctors Veterinary Clinic"; ?></strong><br>
                      <?php echo "Purok Dahlia, Lower Taway, Ipil, Zamboanga Sibugay"; ?><br>
                      Phone: <?php echo "(062)957-6029/0997-1925-474"; ?><br>
                      Email: <a
                        href="mailto:<?php echo "ipdvc2023@gmail.com"; ?>"><?php echo "ipdvc2023@gmail.com"; ?></a>
                    </address>
                  </div>
                  <div class="col-md-6">
                    <h2>Contact Form</h2>
                    <!-- Example of a simple contact form -->
                    <form action="" method="POST">
                      <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" class="form-control" id="name"
                          value="<?php echo $user['firstname'] . " " . $user['lastname']; ?>" name="name" required
                          disabled>
                      </div>
                      <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" class="form-control" id="email" value="<?php echo $user['email']; ?>"
                          name="email" required disabled>
                      </div>
                      <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary" name="send">Send Message</button>
                    </form>


                  </div>
                </div>
              <?php else: ?>

                <div class="row">
                  <div class="col-md-6">
                    <h2>Contact Information</h2>
                    <address>
                      <strong><?php echo "Ipil Pet Doctors Veterinary Clinic"; ?></strong><br>
                      <?php echo "Purok Dahlia, Lower Taway, Ipil, Zamboanga Sibugay"; ?><br>
                      Phone: <?php echo "(062)957-6029/0997-1925-474"; ?><br>
                      Email: <a
                        href="mailto:<?php echo "ipdvc2023@gmail.com"; ?>"><?php echo "ipdvc2023@gmail.com"; ?></a>
                    </address>
                  </div>
                  <div class="col-md-6">
                    <h2>Contact Form</h2>
                    <!-- Example of a simple contact form -->
                    <form action="" method="POST">
                      <div class="form-group">
                        <label for="name">Your Name:</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                      </div>
                      <div class="form-group">
                        <label for="email">Your Email:</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                      </div>
                      <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required></textarea>
                      </div>
                      <button type="submit" class="btn btn-primary" name="send">Send Message</button>
                    </form>


                  </div>
                </div>
              <?php endif; ?>


            </div><!-- /.col-sm-12 -->
          </div><!-- /.row -->
        </div><!-- /.content -->
      </div><!-- /.container -->
    </div><!-- /.content-wrapper -->

    <?php include ('includes/footer.php'); ?>
    <?php include ('includes/appointment_modal.php'); ?>

  </div><!-- ./wrapper -->

  <?php include ('includes/scripts.php'); ?>
  <?php
  if (isset($_POST['send'])) {
    // Retrieve form data
    $fullname = $user['firstname'] . ' ' . $user['lastname'];
    $email = $user['email'];
    $message = $_POST['message'];

    // SQL query to insert data into feedback table
    $sql = "INSERT INTO feedback (fullname, email, message) VALUES ('$fullname', '$email', '$message')";

    if ($conn->query($sql) === TRUE) {
      echo "<script>
        Swal.fire({
            icon: 'success',
            title: 'Success...',
            text: '" . "Feedback sent Successfully" . "',
        }).then(function() {
            window.location.href = 'contact_us.php';
        });
      </script>";
      // You can redirect or show a success message here
    } else {
      echo "Error: " . $sql . "<br>" . $conn->error;
    }
  }
  ?>
</body>

</html>