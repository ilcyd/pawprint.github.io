<?php
include 'includes/session.php';

$where = '';
if (isset($_GET['category'])) {
    $catid = $_GET['category'];
    $where = 'WHERE category_id =' . $catid;
}
if (isset($_GET['subcategory'])) {
    $subcatid = $_GET['subcategory'];
    $where = 'WHERE subcategory_id =' . $subcatid;
}

include 'includes/header.php'; ?>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Preloader -->
        <!-- <div class="preloader flex-column justify-content-center align-items-center">
        <img class="animation__shake" src="../images/logo.jpg" alt="AdminLTELogo" height="60" width="60">
    </div> -->

        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Inventory</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">All Products</li>
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
                                <div class="card-header">
                                    <a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat" id="addproduct"><i
                                            class="fa fa-plus"></i> New</a>
                                    <div class="float-right">
                                        <form class="form-inline">
                                            <div class="form-group mr-2">
                                                <label for="select_category">Category:</label>
                                                <select class="form-control" id="select_category">
                                                    <option value="0">ALL</option>
                                                    <?php
                                                    // Your category options here
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="select_subcategory">Subcategory:</label>
                                                <select class="form-control" id="select_subcategory">
                                                    <option value="0">ALL</option>
                                                </select>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Category Name</th>
                                                    <th>Sub Category Name</th>
                                                    <th>Product Name</th>
                                                    <th>Photo</th>
                                                    <th>Description</th>
                                                    <th>Price</th>
                                                    <th>Stock</th>
                                                    <th>Views Today</th>
                                                    <th>Expiry Date</th>
                                                    <th>New Product Expiry Date</th>
                                                    <th>Tools</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                // Fetch current settings for discount logic
                                                $fetch2 = "SELECT * FROM settings LIMIT 1";
                                                $result2 = mysqli_query($conn, $fetch2);
                                                $row1 = mysqli_fetch_assoc($result2);

                                                $discount_show_time = $row1['discount_show_time']; // days
                                                $discount_percent = $row1['discount_percent']; // percentage

                                                $now = date('Y-m-d');
                                                $sql = "SELECT p.*, c.name AS category_name, sc.name AS subcategory_name
        FROM products p
        LEFT JOIN category c ON p.category_id = c.id
        LEFT JOIN subcategory sc ON p.subcategory_id = sc.id 
        WHERE p.delete_flag = 0";

                                                $result = mysqli_query($conn, $sql);

                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $expiry_date = $row['expiry_date'];
                                                        $discounted_price = $row['price']; // Default price

                                                        // Calculate the difference in days
                                                        $time_difference = (strtotime($expiry_date) - strtotime($now)) / (60 * 60 * 24); // days

                                                        // Check if the product is about to expire and apply discount if within the discount_show_time
                                                        if ($time_difference >= 0 && $time_difference <= $discount_show_time) {
                                                            $discounted_price = $row['price'] * ((100 - $discount_percent) / 100);

                                                            // Update the discount_price in the database
                                                            $update_sql = "UPDATE products SET discount_price = ? WHERE id = ?";
                                                            $stmt = $conn->prepare($update_sql);
                                                            $stmt->bind_param("di", $discounted_price, $row['id']);
                                                            $stmt->execute();
                                                            $stmt->close();
                                                        } else {
                                                            // Use the existing discount price if set
                                                            $discounted_price = !empty($row['discount_price']) ? $row['discount_price'] : $row['price'];
                                                        }

                                                        // Check if stock is 0 or if expiry date is today, and handle the transfer of values
                                                        $currentDate = date('Y-m-d'); // Get today's date in 'YYYY-MM-DD' format

                                                        if (($row['stock'] <= 0 || $row['expiry_date'] === $currentDate) && !empty($row['new_stock'])) {
                                                            // Transfer new stock to stock and new expiry date to expiry date
                                                            $new_price = $row['new_price'];
                                                            $new_stock = $row['new_stock'];
                                                            $new_expiry_date = $row['new_exp_date'];

                                                            // Update the stock, expiry date, reset discount price, set new price
                                                            $update_product_query = "UPDATE products SET stock = ?, expiry_date = ?, discount_price = NULL, price = ? WHERE id = ?";
                                                            $stmt = $conn->prepare($update_product_query);

                                                            // Bind parameters: "isi" corresponds to int, string, int
                                                            $stmt->bind_param("isii", $new_stock, $new_expiry_date, $new_price, $row['id']);

                                                            // Execute the statement
                                                            if ($stmt->execute()) {
                                                                // Prepare to set new fields to NULL after successful update
                                                                $reset_query = "UPDATE products SET new_price = NULL, new_stock = NULL, new_exp_date = NULL WHERE id = ?";
                                                                $reset_stmt = $conn->prepare($reset_query);
                                                                $reset_stmt->bind_param("i", $row['id']);

                                                                if (!$reset_stmt->execute()) {
                                                                    error_log('Error resetting new fields: ' . $reset_stmt->error);
                                                                }

                                                                $reset_stmt->close();
                                                            } else {
                                                                // Optionally handle errors
                                                                error_log('Error updating product: ' . $stmt->error);
                                                            }

                                                            $stmt->close();
                                                        }



                                                        // Display product data
                                                        echo "<tr>";
                                                        echo "<td>" . htmlspecialchars($row['category_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['subcategory_name']) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                                        echo "<td><img src='" . (!empty($row['photo']) ? '../images/' . $row['photo'] : '../images/noimage.jpg') . "' height='70px' width='70px'></td>";
                                                        echo "<td>" . htmlspecialchars($row['description']) . "</td>";
                                                        echo "<td>" . number_format($discounted_price, 2) . "</td>"; // Display discounted price or default price
                                                        echo "<td>" . $row['stock'] . "<br>";
                                                        if ($row['stock'] <= $row1['crit_level']) {
                                                            echo '<span class="badge badge-danger">Restock Needed</span>';
                                                        }
                                                        echo "</td>";
                                                        echo "<td>" . ($row['date_view'] == $now ? $row['counter'] : 0) . "</td>";
                                                        echo "<td>" . htmlspecialchars($expiry_date) . "</td>";
                                                        echo "<td>" . htmlspecialchars($row['new_exp_date']) . "</td>";
                                                        echo "<td> 
            <button class='btn btn-primary btn-sm add btn-flat' data-id='" . $row['id'] . "'> Add</button>
            <button class='btn btn-success btn-sm edit btn-flat' data-id='" . $row['id'] . "'> Edit</button>
            <button class='btn btn-danger btn-sm delete btn-flat' data-id='" . $row['id'] . "'> Delete</button></td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='10'>No products found.</td></tr>";
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
        <?php include 'includes/products_modal.php'; ?>
        <?php include 'includes/products_modal2.php'; ?>
    </div>
    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function() {
            // Handle click events for edit, delete, and add buttons
            $(document).on('click', '.edit, .delete, .add', function(e) {
                e.preventDefault();
                var id = $(this).data('id');

                if ($(this).hasClass('edit')) {
                    $('#edit').modal('show');
                    getRow(id); // Fetch and populate data for editing
                } else if ($(this).hasClass('delete')) {
                    $('#delete').modal('show');
                } else if ($(this).hasClass('add')) {
                    $('#add').modal('show'); // Show add modal
                    getRow(id); // Fetch and populate data for editing
                }
            });

            // Handle category and subcategory selection changes
            $('#select_category, #select_subcategory').change(function() {
                var val = $(this).val();
                var baseUrl = 'products.php';
                if ($(this).attr('id') === 'select_category') {
                    window.location = val == 0 ? baseUrl : baseUrl + '?category=' + val;
                } else {
                    window.location = val == 0 ? baseUrl : baseUrl + '?subcategory=' + val;
                }
            });

            // Handle click event to add a new product
            $('#addproduct').click(function(e) {
                e.preventDefault();
                getCategory();
                getSubCategory();
            });

            // Clean up when modals are hidden
            $("#add, #edit").on("hidden.bs.modal", function() {
                $('.append_items').remove();
            });

            // Function to get product details and populate edit modal
            function getRow(id) {
                $.ajax({
                    type: 'POST',
                    url: 'products_row.php',
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#desc').html(response.description);
                        $('.name').html(response.prodname);
                        $('.prodid').val(response.prodid);
                        $('#edit_name').val(response.prodname);
                        $('#product_name').val(response.prodname);
                        $('#catselected').val(response.category_id).html(response.catname);
                        $('#subcatselected').val(response.subcategory_id).html(response.subcatname);
                        $('#edit_price').val(response.price);
                        $('#editor2').val(response.description);
                        getCategory(); // Fetch categories for the edit modal
                        getSubCategory(); // Fetch subcategories for the edit modal
                    },
                    error: function() {
                        alert('Error fetching product details');
                    }
                });
            }

            // Function to get categories and populate category dropdowns
            function getCategory() {
                $.ajax({
                    type: 'POST',
                    url: 'category_fetch.php',
                    dataType: 'json',
                    success: function(response) {
                        $('#select_category').html(response);
                        $('#edit_category').html(response); // Update categories in both add and edit modals
                    },
                    error: function() {
                        alert('Error fetching categories');
                    }
                });
            }

            // Handle category change to load corresponding subcategories
            $('#category').change(function() {
                var category_id = $(this).val();
                if (category_id) {
                    getSubCategory(category_id);
                } else {
                    $('#subcategory').html('<option value="">- Select -</option>');
                }
            });

            // Function to get subcategories based on category ID and populate dropdown
            function getSubCategory(category_id) {
                $.ajax({
                    type: 'POST',
                    url: 'subcategory_fetch.php',
                    data: {
                        category_id: category_id
                    },
                    dataType: 'json',
                    success: function(response) {
                        $('#select_subcategory').html(response);
                    },
                    error: function() {
                        alert('Error fetching subcategories');
                    }
                });
            }
        });
    </script>
</body>

</html>