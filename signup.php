<?php include 'includes/session.php'; ?>
<?php
if (isset($_SESSION['user'])) {
  header('location: cart_view.php');
}
?>
<?php include 'includes/header.php'; ?>
<style>
  body {
    background-image: url('images/bg1.jpg');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .register-box {
    background: rgba(255, 255, 255, 0.9);
    /* Semi-transparent white */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }
</style>

<body class="hold-transition register-page">
  <div class="register-box">
    <?php
    if (isset($_SESSION['error'])) {
      echo "
          <div class='callout callout-danger text-center'>
            <p>" . $_SESSION['error'] . "</p> 
          </div>
        ";
      unset($_SESSION['error']);
    }

    if (isset($_SESSION['success'])) {
      echo "
          <div class='callout callout-success text-center'>
            <p>" . $_SESSION['success'] . "</p> 
          </div>
        ";
      unset($_SESSION['success']);
    }
    ?>

    <div class="register-box-body">
      <p class="login-box-msg">Register a new membership</p>

      <form action="register.php" method="POST" enctype="multipart/form-data">
        <div class="form-group has-feedback">
          <label for="firstname">First Name</label>
          <input type="text" class="form-control" name="firstname" placeholder="Firstname" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <label for="middlename">Middle Name</label>
          <input type="text" class="form-control" name="middlename" placeholder="(Optional)">
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <label for="lastname">Last Name</label>
          <input type="text" class="form-control" name="lastname" placeholder="Lastname" required>
          <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <label for="email">Email</label>
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <label for="password">Password</label>
          <input type="password" class="form-control" name="password" placeholder="Password" required>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <label for="repassword">Re-Enter Password</label>
          <input type="password" class="form-control" name="repassword" placeholder="Retype password" required>
          <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <label for="contact">Contact No.</label>
          <input type="text" class="form-control" name="contact" placeholder="Contact" pattern="\d{0,11}" maxlength="11"
            oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);" required>
          <span class="glyphicon glyphicon-phone-alt form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <label for="address">Address</label>
          <div class="row">
            <div class="col-md-6">
              <div class="input-group mb-3">
                <select class="form-control" name="province" id="province" required>
                </select>
              </div>
              <div class="input-group mb-3">
                <select class="form-control" name="municipality" id="municipality" required>
                </select>
              </div>
            </div>
            <div class="col-md-6">
              <div class="input-group mb-3">
                <select class="form-control" name="barangay" id="barangay" required>
                </select>
              </div>
              <div class="input-group mb-3">
                <input type="text" class="form-control" placeholder="Purok or Additional Info"
                  name="additional_address_info">
              </div>
            </div>
          </div>
        </div>

        <div class="form-group has-feedback">
          <label for="valid_id_type">Valid ID Type</label>
          <?php
          $sql = "SELECT * FROM valid_id_type";
          $result = $conn->query($sql);

          if ($result->num_rows > 0) {
            echo '<select name="valid_id_type" class="form-control input-sm" id="valid_id_type" required>';
            $separator_added = false;
            while ($row = $result->fetch_assoc()) {
              if ($row['type'] == 2 && !$separator_added) {
                // Add a separator before the first type=2 option
                echo '<option disabled>Secondary Valid IDs</option>';
                $separator_added = true;
              }
              echo '<option value="' . $row['id'] . '">' . $row['name'] . '</option>';
            }
            echo '</select>';
          } else {
            echo '<select name="valid_id_type" id="valid_id_type">';
            echo '<option value="">No valid ID types available</option>';
            echo '</select>';
          }
          ?>
        </div>
        <div class="form-group">
          <label for="valid_id" class="col-sm-9 control-label">Valid ID</label>
          <div class="col-sm-9">
            <input type="file" id="valid_id" name="valid_id" required>
          </div>
        </div>
        <div class="form-group">
          <label for="profile" class="col-sm-9 control-label">Profile</label>
          <div class="col-sm-9">
            <input type="file" id="profile" name="profile" required>
          </div>
        </div>
        <hr>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="signup"><i class="fa fa-pencil"></i>
              Sign Up</button>
          </div>
        </div>
      </form>
      <br>
      <a href="login.php">I already have a membership</a><br>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
    </div>
  </div>

  <?php include 'includes/scripts.php' ?>
</body>

</html>