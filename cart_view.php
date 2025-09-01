<?php
include ('includes/header.php');
include ('includes/session.php');
?>

<body class="hold-transition layout-top-nav sidebar-collapse">
  <div class="wrapper">
    <!-- Preloader (Optional) -->
    <!-- <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60" width="60">
    </div> -->

    <?php include ('includes/navbar.php'); ?>

    <div class="content-wrapper">
      <div class="container">
        <section class="content">
          <div class="row">
            <div class="col-sm-9">
              <h1 class="page-header">YOUR CART</h1>
              <div class="box box-solid">
                <div class="box-body">
                  <table class="table table-bordered" id="example1">
                    <thead>
                      <th></th>
                      <th>Photo</th>
                      <th>Name</th>
                      <th>Price</th>
                      <th width="20%">Quantity</th>
                      <th>Subtotal</th>
                    </thead>
                    <tbody id="tbody">
                    </tbody>
                  </table>
                </div>
              </div>
              <?php
              if (isset($_SESSION['user'])) {
                echo "<form action='gcash_payment.php' method='post'>
        <button type='submit' class='btn' style='background-color: #007bff; color: white; border-radius: 20px; padding: 5px 15px; font-size: 14px;'>
            Pay with GCash
        </button>
      </form>";

              } else {
                echo "<h4>You need to <a href='login.php'>Login</a> to checkout.</h4>";
              }
              ?>
            </div>
            <div class="col-sm-3">
              <?php include 'includes/sidebar.php'; ?>
            </div>
          </div>
        </section>
      </div>
    </div>
    <?php include 'includes/footer.php'; ?>
    <?php include ('includes/appointment_modal.php'); ?>

  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    var total = 0;
    $(function () {
      $(document).on('click', '.cart_delete', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        $.ajax({
          type: 'POST',
          url: 'cart_delete.php',
          data: { id: id },
          dataType: 'json',
          success: function (response) {
            if (!response.error) {
              getDetails();
              getCart();
              getTotal();
            }
          }
        });
      });

      $(document).on('click', '.minus', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_' + id).val();
        if (qty > 1) {
          qty--;
        }
        $('#qty_' + id).val(qty);
        $.ajax({
          type: 'POST',
          url: 'cart_update.php',
          data: {
            id: id,
            qty: qty,
          },
          dataType: 'json',
          success: function (response) {
            if (!response.error) {
              getDetails();
              getCart();
              getTotal();
            }
          }
        });
      });

      $(document).on('click', '.add', function (e) {
        e.preventDefault();
        var id = $(this).data('id');
        var qty = $('#qty_' + id).val();
        qty++;
        $('#qty_' + id).val(qty);
        $.ajax({
          type: 'POST',
          url: 'cart_update.php',
          data: {
            id: id,
            qty: qty,
          },
          dataType: 'json',
          success: function (response) {
            if (!response.error) {
              getDetails();
              getCart();
              getTotal();
            }
          }
        });
      });

      getDetails();
      getTotal();

    });

    function getDetails() {
      $.ajax({
        type: 'POST',
        url: 'cart_details.php',
        dataType: 'html', // Changed to 'html'
        success: function (response) {
          $('#tbody').html(response);
        },
        error: function (xhr, status, error) {
          console.error("Error fetching cart details:", error);
        }
      });
    }

    function getTotal() {
      $.ajax({
        type: 'POST',
        url: 'cart_total.php',
        dataType: 'json',
        success: function (response) {
          total = response; // Assuming response is a number representing the total
        },
        error: function (xhr, status, error) {
          console.error("Error fetching cart total:", error);
        }
      });
    }
  </script>
  <!-- Paypal Express -->
  <!-- <script src="https://www.paypalobjects.com/api/checkout.js"></script> -->
  <!-- <script>
    paypal.Button.render({
      env: 'sandbox', // change for production if app is live,
      client: {
        sandbox: 'AcUnDyNEdE_vvu4o_fdVHGRdw4mlZNJ3o5uD9ylHGYoCYdCbhl5VjbSI_Eu50yvqFuFAq9hHpbrKona8',
        //production: 'AaBHKJFEej4V6yaArjzSx9cuf-UYesQYKqynQVCdBlKuZKawDDzFyuQdidPOBSGEhWaNQnnvfzuFB9SM'
      },
      commit: true, // Show a 'Pay Now' button
      style: {
        color: 'gold',
        size: 'small'
      },
      payment: function (data, actions) {
        return actions.payment.create({
          payment: {
            transactions: [
              {
                //total purchase
                amount: {
                  total: total,
                  currency: 'PHP'
                }
              }
            ]
          }
        });
      },
      onAuthorize: function (data, actions) {
        return actions.payment.execute().then(function (payment) {
          window.location = 'sales.php?pay=' + payment.id;
        });
      },

    }, '#paypal-button');
  </script> -->
</body>

</html>