<?php include 'includes/session.php'; ?>
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

  .login-box {
    background: rgba(255, 255, 255, 0.9);
    /* Semi-transparent white */
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
  }
</style>

<body class="hold-transition login-page">
  <div class="login-box">
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
    <div class="login-box-body">
      <p class="login-box-msg">Enter email associated with account</p>

      <form action="reset.php" method="POST">
        <div class="form-group has-feedback">
          <input type="email" class="form-control" name="email" placeholder="Email" required>
          <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="row">
          <div class="col-xs-4">
            <button type="submit" class="btn btn-primary btn-block btn-flat" name="reset"><i
                class="fa fa-mail-forward"></i> Send</button>
          </div>
        </div>
      </form>
      <br>
      <a href="login.php">I remembered my password</a><br>
      <a href="index.php"><i class="fa fa-home"></i> Home</a>
    </div>
  </div>

  <?php include 'includes/scripts.php' ?>
</body>

</html>