<?php include 'includes/header.php'; ?>
<?php include 'includes/session.php'; ?>
<?php
if (isset($_SESSION['user'])) {
  header('location: cart_view.php');
  exit();
}
?>
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

  .login-box {
    background: rgba(255, 255, 255, 0.9); /* Semi-transparent white */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }

  .btn-primary {
    background: #4CAF50; /* Modern green */
    border: none;
    transition: 0.3s;
  }

  .btn-primary:hover {
    background: #45a049;
  }

  .form-control {
    border-radius: 4px;
  }

  .toggle-password {
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
  }

  .toggle-password i {
    font-size: 18px;
  }
</style>

<body class="hold-transition login-page">
  <div class="login-box">
    <?php
    if (isset($_SESSION['error'])) {
      echo "<div class='callout callout-danger text-center'><p>" . $_SESSION['error'] . "</p></div>";
      unset($_SESSION['error']);
    }
    if (isset($_SESSION['success'])) {
      echo "<div class='callout callout-success text-center'><p>" . $_SESSION['success'] . "</p></div>";
      unset($_SESSION['success']);
    }
    ?>

    <div class="login-box-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="verify.php" method="POST">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>

        <div class="form-group has-feedback">
          <div class="input-group">
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
            <div class="input-group-append">
              <button type="button" class="toggle-password" id="togglePassword">
                <i class="fa fa-eye"></i>
              </button>
            </div>
          </div>
          <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="login">
              <i class="fa fa-sign-in"></i> Sign In
            </button>
          </div>
        </div>
      </form>

      <br>
      <a href="password_forgot.php">I forgot my password</a><br>
      <a href="signup.php" class="text-center">Register a new membership</a><br>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
    </div>
  </div>

  <?php include 'includes/scripts.php' ?>

  <script>
    // Toggle password visibility
    document.querySelector("#togglePassword").addEventListener("click", function () {
      const passwordField = document.querySelector("#password");
      const type = passwordField.getAttribute("type") === "password" ? "text" : "password";
      passwordField.setAttribute("type", type);
      this.querySelector("i").classList.toggle("fa-eye");
      this.querySelector("i").classList.toggle("fa-eye-slash");
    });
  </script>

</body>

</html>
