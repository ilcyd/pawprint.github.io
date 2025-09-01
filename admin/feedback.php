<?php
include 'includes/session.php';
?>
<?php include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
        </div>

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Customers Feedback</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Feedback</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Email</th>
                                                    <th>Full Name</th>
                                                    <th>Message</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $sql = "SELECT * FROM feedback";
                                                $result = mysqli_query($conn, $sql);
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo "
                                                            <tr>
                                                                <td>" . $row['email'] . "</td>
                                                                <td>" . $row['fullname'] . "</td>
                                                                <td>" . substr($row['message'], 0, 50) . "...</td>
                                                                <td>
                                                                    <button class='btn btn-info btn-sm view-more btn-flat' data-id='" . $row['id'] . "'>View More</button>
                                                                </td>
                                                            </tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='4'><center>No feedback found.</center></td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/feedback_modal.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function () {
            $(document).on('click', '.view-more', function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                $('#feedbackModal').modal('show');
                loadFeedbackDetails(id);
            });

            function loadFeedbackDetails(id) {
                $.ajax({
                    url: 'fetch_feedback_details.php', // PHP script to fetch feedback details
                    method: 'POST',
                    data: { feedback_id: id },
                    success: function (response) {
                        $('#feedbackDetailsContent').html(response); // Assume you have an element with this ID
                    },
                    error: function () {
                        $('#feedbackDetailsContent').html('<p>An error occurred while fetching details.</p>');
                    }
                });
            }
        });
    </script>
</body>

</html>