<?php
include 'includes/session.php';
include 'includes/header.php';

// Fetch all available products from the database
$sql_products = "SELECT id, name, price, discount_price, stock, photo FROM products WHERE delete_flag = 0";
$products = mysqli_query($conn, $sql_products);

// Fetch all customers from the database (type 0 for customers)
$sql_customers = "SELECT id, firstname, lastname FROM users WHERE type = 0 AND status=1 AND delete_flag = 0";
$customers = mysqli_query($conn, $sql_customers);
?>
<style>
    #update-quantity {
        width: 60px;
        /* Fixed width */
        text-align: center;
    }

    .product-card img {
        width: 100%;
        height: 200px;
        /* Set a fixed height for uniformity */
        object-fit: cover;
    }

    .search-bar {
        margin-bottom: 20px;
    }
</style>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <?php include 'includes/navbar.php'; ?>
        <?php include 'includes/sidebar.php'; ?>

        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Point of Sale</h1>
                        </div>
                    </div>
                </div>
            </div>

            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Order Summary & Customer Section (Right Side) -->
                        <div class="col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <h4>Select Customer</h4>
                                    <div class="form-group">
                                        <select id="customer-select" class="form-control">
                                            <option value="">Select Customer</option>
                                            <?php while ($customer = mysqli_fetch_assoc($customers)) { ?>
                                                <option value="<?php echo $customer['id']; ?>">
                                                    <?php echo $customer['firstname'] . ' ' . $customer['lastname']; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <button class="btn btn-secondary" data-toggle="modal" data-target="#addCustomerModal">Add Customer</button>

                                    <h4 class="mt-4">Order Summary</h4>
                                    <div class="table-responsive" style="overflow-y: auto; width: 100%;">
                                        <table class="table table-bordered" id="order-summary">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th>Qty</th>
                                                    <th>Price</th>
                                                    <th>Total</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="4" class="text-right"><strong>Grand Total:</strong></td>
                                                    <td id="grand-total">₱0.00</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                    <button class="btn btn-success btn-block" id="checkout">Add Transaction</button>
                                </div>
                            </div>
                        </div>

                        <!-- Product Selection Section (Left Side) -->
                        <div class="col-md-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="search-bar">
                                        <input type="text" id="product-search" class="form-control" placeholder="Search Products">
                                    </div>
                                    <div class="row" id="product-list">
                                        <?php while ($product = mysqli_fetch_assoc($products)) { ?>
                                            <div class="col-md-4 product-item">
                                                <div class="card product-card">
                                                    <img src="../images/<?php echo $product['photo']; ?>" class="card-img-top" alt="Product Image">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                                        <p class="card-text">Price: ₱<?php echo $product['price']; ?></p>
                                                        <p class="card-text">Stock: <?php echo $product['stock']; ?></p>
                                                        <button
                                                            class="btn btn-primary add-to-cart"
                                                            data-id="<?php echo $product['id']; ?>"
                                                            data-price="<?php echo $product['price']; ?>"
                                                            data-name="<?php echo $product['name']; ?>"
                                                            data-stock="<?php echo $product['stock']; ?>"
                                                            <?php echo ($product['stock'] == 0) ? 'disabled' : ''; ?>>
                                                            <?php echo ($product['stock'] == 0) ? 'Out of Stock' : 'Add to Cart'; ?>
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>

        <!-- Modal for Adding New Customer -->
        <div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCustomerModalLabel">Add New Customer</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="add-customer-form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="firstname">First Name</label>
                                <input type="text" class="form-control" id="firstname" required>
                            </div>
                            <div class="form-group">
                                <label for="lastname">Last Name</label>
                                <input type="text" class="form-control" id="lastname" required>
                            </div>
                            <div class="form-group">
                                <label for="contact">Contact</label>
                                <input type="text" class="form-control" id="contact" required>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" id="address" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Add Customer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- Modal for Cashier (Payment, Tax, Change) -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Cashier</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <h5>Order Summary</h5>
                        <table class="table">
                            <tr>
                                <td>Grand Total</td>
                                <td id="checkout-grand-total">₱0.00</td>
                            </tr>
                            <tr>
                                <td>Tax (5%)</td>
                                <td id="checkout-tax">₱0.00</td>
                            </tr>
                            <tr>
                                <td>Total with Tax</td>
                                <td id="checkout-total-with-tax">₱0.00</td>
                            </tr>
                            <tr>
                                <td>Payment</td>
                                <td><input type="number" id="payment" class="form-control" placeholder="Enter Payment" required /></td>
                            </tr>
                            <tr>
                                <td>Change</td>
                                <td id="checkout-change">₱0.00</td>
                            </tr>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="confirm-payment">Confirm Payment</button>
                    </div>
                </div>
            </div>
        </div>


        <?php include 'includes/footer.php'; ?>
        <?php include 'includes/scripts.php'; ?>

        <script>
            let cart = [];
            let selectedCustomer = null;

            // Update selected customer ID when dropdown changes
            $('#customer-select').on('change', function() {
                selectedCustomer = $(this).val();
            });

            $(document).on('click', '.add-to-cart', function() {
                const productId = $(this).data('id');
                const productName = $(this).data('name');
                const productPrice = $(this).data('price');
                const availableStock = $(this).data('stock');

                const existingProduct = cart.find(item => item.id === productId);

                if (existingProduct) {
                    existingProduct.qty += 1;
                } else {
                    cart.push({
                        id: productId,
                        name: productName,
                        price: productPrice, // Include price here
                        qty: 1,
                        stock: availableStock
                    });
                    // Disable the "Add to Cart" button
                    $(this).prop('disabled', true).text('In Cart');
                }

                renderCart();
            });

            // Render the cart in the Order Summary table
            function renderCart() {
                let grandTotal = 0;
                const taxRate = 0.05; // 5% tax
                const $tbody = $('#order-summary tbody');
                $tbody.empty();

                cart.forEach((item, index) => {
                    const itemQty = Number(item.qty) || 0;
                    const itemPrice = Number(item.price) || 0;
                    const itemTotal = itemPrice * itemQty;
                    grandTotal += itemTotal;

                    $tbody.append(`
            <tr data-index="${index}">
                <td>${item.name}</td>
                <td>
                    <input type="number" id="update-quantity" min="1" value="${itemQty}" style="width: 60px; text-align: center;" oninput="this.value = this.value.replace(/^0+/, '');">
                </td>
                <td>₱${itemPrice.toFixed(2)}</td>
                <td>₱${itemTotal.toFixed(2)}</td>
                <td>
                    <button class="btn btn-danger btn-sm remove-item">Remove</button>
                </td>
            </tr>
        `);
                });

                // Calculate tax and total with tax
                const taxAmount = grandTotal * taxRate;
                const totalWithTax = grandTotal + taxAmount;

                // Update the grand total and tax
                $('#grand-total').text(`₱${grandTotal.toFixed(2)}`);
                $('#checkout-grand-total').text(`₱${grandTotal.toFixed(2)}`);
                $('#checkout-tax').text(`₱${taxAmount.toFixed(2)}`);
                $('#checkout-total-with-tax').text(`₱${totalWithTax.toFixed(2)}`);
            }

            // Update item quantity in the cart
            $(document).on('change', '#update-quantity', function() {
                const rowIndex = $(this).closest('tr').data('index');
                const newQuantity = Number($(this).val()) || 0; // Get the updated quantity value
                const availableStock = cart[rowIndex].stock;

                // Ensure the quantity doesn't exceed stock
                if (newQuantity > availableStock) {
                    alert('Stock limit reached.');
                    $(this).val(cart[rowIndex].qty); // Reset to original quantity if limit exceeded
                    return;
                }

                // Update the quantity in the cart array
                cart[rowIndex].qty = newQuantity;

                // Re-render the cart and update the grand total
                renderCart();
            });

            // Remove item from cart
            $(document).on('click', '.remove-item', function() {
                const rowIndex = $(this).closest('tr').data('index');
                const removedItem = cart[rowIndex]; // Get the removed item

                cart.splice(rowIndex, 1);
                renderCart();

                // Re-enable the "Add to Cart" button for the removed product
                $(`.add-to-cart[data-id="${removedItem.id}"]`).prop('disabled', false).text('Add to Cart');
            });

            // Payment Modal - Payment calculation and change
            $(document).on('input', '#payment', function() {
                const totalWithTax = Number($('#checkout-total-with-tax').text().replace('₱', ''));
                const payment = Number($(this).val());

                if (payment >= totalWithTax) {
                    const change = payment - totalWithTax;
                    $('#checkout-change').text(`₱${change.toFixed(2)}`);
                } else {
                    $('#checkout-change').text('₱0.00');
                }
            });

            // Checkout - Confirm Payment
            $('#confirm-payment').on('click', function() {
                const totalWithTax = Number($('#checkout-total-with-tax').text().replace('₱', ''));
                const payment = Number($('#payment').val());
                const change = payment - totalWithTax;

                if (payment < totalWithTax) {
                    alert("Insufficient payment. Please enter a valid payment amount.");
                    return;
                }

                // Send checkout data to the server for processing
                $.ajax({
                    url: 'process_checkout.php',
                    type: 'POST',
                    data: JSON.stringify({
                        customer_id: selectedCustomer,
                        items: cart, // Send the full cart including price
                        total_with_tax: totalWithTax,
                        grandTotal: grandTotal,
                        payment: payment,
                        change: change
                    }),
                    contentType: 'application/json',
                    success: function(response) {
                        if (response) {
                            // Check if the response has a success flag
                            if (response.success) {
                                alert("Transaction Completed Successfully!");
                                cart = []; // Clear cart after successful transaction
                                selectedCustomer = null;
                                renderCart(); // Re-render cart (clear it)
                                $('#customer-select').val(''); // Reset customer selection
                                location.reload(); // Reload the page after transaction
                            } else {
                                alert("Error processing order: " + response.message);
                            }
                        } else {
                            alert("Empty response from the server.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Error processing order:", error);
                        alert("An error occurred. Please try again.");
                    }
                });
            });


            // Checkout - Submit order
            $('#checkout').on('click', function() {
                // Ensure the cart and customer selection are valid before submitting
                if (cart.length === 0) {
                    alert("Please add items to the cart.");
                    return;
                }
                if (!selectedCustomer) {
                    alert("Please select a customer.");
                    return;
                }

                // Show the payment modal
                $('#paymentModal').modal('show');
            });
        </script>

</body>



</html>