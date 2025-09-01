<?php
include('includes/header.php');
include('includes/session.php');
?>
<style>
  .profile-info {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    /* Space between items */
  }

  .profile-item {
    flex: 1;
    min-width: 200px;
    /* Adjust width as needed */
    box-sizing: border-box;
  }

  .profile-item strong {
    display: block;
    font-weight: bold;
  }

  .profile-item span {
    display: block;
  }

  .profile-edit {
    margin-top: 10px;
    flex-basis: 100%;
    /* Make sure the edit button takes full width */
  }

  /* Ensure the table is responsive and full-width */
  .table {
    width: 100%;
    margin-bottom: 1rem;
    color: #212529;
  }
</style>

<body class="hold-transition layout-top-nav sidebar-collapse">
  <div class="wrapper">
    <?php include('includes/navbar.php'); ?>

    <div class="content-wrapper">
      <div class="container">
        <section class="content">
          <div class="row">
            <div class="col-sm-9">
              <div class="box box-solid">
                <div class="box-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <img
                        src="<?php echo (!empty($user['profile'])) ? 'images/' . $user['profile'] : 'images/profile.jpg'; ?>"
                        width="100%">
                    </div>
                    <div class="col-sm-9">
                      <div class="profile-info">
                        <div class="profile-item">
                          <strong>Name:</strong>
                          <span><?php echo $user['firstname'] . ' ' . $user['lastname']; ?></span>
                        </div>
                        <div class="profile-item">
                          <strong>Email:</strong>
                          <span><?php echo $user['email']; ?></span>
                        </div>
                        <div class="profile-item">
                          <strong>Contact Info:</strong>
                          <span><?php echo (!empty($user['contact'])) ? $user['contact'] : 'N/a'; ?></span>
                        </div>
                        <div class="profile-item">
                          <strong>Address:</strong>
                          <span><?php echo (!empty($user['address'])) ? $user['address'] : 'N/a'; ?></span>
                        </div>
                        <div class="profile-item">
                          <strong>Member Since:</strong>
                          <span><?php echo date('M d, Y', strtotime($user['date_created'])); ?></span>
                        </div>
                        <div class="profile-edit">
                          <a href="#edit" class="btn btn-success btn-flat btn-sm" data-toggle="modal">
                            <i class="fa fa-edit"></i> Edit
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="box box-solid">
                <div class="box-header with-border">
                  <h4 class="box-title"><i class="fa fa-calendar"></i> <b>Transaction History</b></h4>
                </div>
                <div class="box-body">
                  <table class="table table-bordered" id="example1">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Date</th>
                        <th>Transaction#</th>
                        <th>Amount</th>
                        <th>Full Details</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      try {
                        // Prepare and execute the main query to fetch sales data
                        $stmt = $conn->prepare("SELECT sales.id, sales.sales_date, sales.pay_id, SUM(products.price * details.quantity) AS total_amount 
                                                         FROM sales 
                                                         LEFT JOIN details ON sales.id = details.sales_id 
                                                         LEFT JOIN products ON products.id = details.product_id 
                                                         WHERE sales.user_id = ? 
                                                         GROUP BY sales.id 
                                                         ORDER BY sales.sales_date DESC");
                        $stmt->bind_param("i", $user['id']);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        while ($row = $result->fetch_assoc()) {
                          // Output each row of sales data
                          echo "<tr>";
                          echo "<td></td>";
                          echo "<td>" . date('M d, Y', strtotime($row['sales_date'])) . "</td>";
                          echo "<td>" . $row['pay_id'] . "</td>";
                          echo "<td>&#8369; " . number_format($row['total_amount'], 2) . "</td>";
                          echo "<td><button class='btn btn-sm btn-flat btn-info transact' data-id='" . $row['id'] . "'><i class='fa fa-search'></i> View</button></td>";
                          echo "</tr>";
                        }
                      } catch (Exception $e) {
                        // Display error message if there's an issue with the database connection or query
                        echo "<tr><td colspan='5'>There is some problem in connection: " . $e->getMessage() . "</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
                </div>
              </div>

            </div>
            <?php include 'includes/sidebar.php'; ?>
          </div>
        </section>
      </div>
    </div>

    <?php include 'includes/footer.php'; ?>
    <?php include 'includes/profile_modal.php'; ?>
    <?php include('includes/appointment_modal.php'); ?>

  </div>

  <?php include 'includes/scripts.php'; ?>
  <script>
    $(function () {
      $(document).on('click', '.transact', function (e) {
        e.preventDefault();
        $('#transaction').modal('show');
        var id = $(this).data('id');
        $.ajax({
          type: 'POST',
          url: 'transaction.php',
          data: { id: id },
          dataType: 'json',
          success: function (response) {
            $('#date').html(response.date);
            $('#transid').html(response.transaction);
            $('#detail').prepend(response.list);
            $('#total').html(response.total);
          }
        });
      });

      $("#transaction").on("hidden.bs.modal", function () {
        $('.prepend_items').remove();
      });
    });
  </script>
</body>

</html>