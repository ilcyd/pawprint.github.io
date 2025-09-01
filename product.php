<?php
include ('includes/session.php');
include ('includes/header.php');

$slug = $_GET['product'];

try {
    // Retrieve product details
    $stmt = $conn->prepare("
        SELECT *, products.name AS prodname, category.name AS catname, products.id AS prodid 
        FROM products 
        LEFT JOIN category ON category.id = products.category_id 
        WHERE slug = ?");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        // Update view counter
        $now = date('Y-m-d');
        if ($product['date_view'] == $now) {
            $stmt = $conn->prepare("UPDATE products SET counter = counter + 1 WHERE id = ?");
            $stmt->bind_param("i", $product['prodid']);
        } else {
            $stmt = $conn->prepare("UPDATE products SET counter = 1, date_view = ? WHERE id = ?");
            $stmt->bind_param("si", $now, $product['prodid']);
        }
        $stmt->execute();
    } else {
        $_SESSION['error'] = 'Product not found.';
        header('Location: products.php');
        exit();
    }
} catch (Exception $e) {
    $_SESSION['error'] = 'Error: ' . $e->getMessage();
    header('Location: products.php');
    exit();
}
?>

<body class="hold-transition layout-top-nav sidebar-collapse">
    <div class="wrapper">
        <?php include ('includes/navbar.php'); ?>

        <div class="content-wrapper">
            <div class="container">
                <section class="content">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="callout" id="callout" style="display:none">
                                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                                <span class="message"></span>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <img src="<?php echo (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg'; ?>"
                                        width="100%" class="zoom"
                                        data-magnify-src="<?php echo 'images/large-' . $product['photo']; ?>">
                                    <br><br>
                                    <form class="form-inline" id="productForm">
                                        <div class="form-group">
                                            <div class="input-group col-sm-5">
                                                <span class="input-group-btn">
                                                    <button type="button" id="minus"
                                                        class="btn btn-default btn-flat btn-lg">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                </span>
                                                <input type="text" name="quantity" id="quantity"
                                                    class="form-control input-lg" value="1" pattern="\d{1,11}" 
                                                    oninput="this.value = this.value.replace(/[^1-9]/g, '').slice(0, 11);">
                                                <span class="input-group-btn">
                                                    <button type="button" id="add"
                                                        class="btn btn-default btn-flat btn-lg">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </span>
                                                <input type="hidden" value="<?php echo $product['prodid']; ?>"
                                                    name="id">
                                            </div>
                                            <button type="submit" id="addToCartBtn"
                                                class="btn btn-primary btn-lg btn-flat">
                                                <i class="fa fa-shopping-cart"></i> Add to Cart
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <div class="col-sm-6">
                                    <h1 class="page-header"><?php echo htmlspecialchars($product['prodname']); ?></h1>
                                    <h3><b>&#8369; <?php echo number_format(!empty($product['discount_price']) ? $product['discount_price'] : $product['price'], 2); ?></b></h3>

                                    <p><b>Category:</b> <a
                                            href="category.php?category=<?php echo $product['cat_slug']; ?>">
                                            <?php echo htmlspecialchars($product['catname']); ?></a></p>
                                    <p><b>Stocks:</b> <?php echo htmlspecialchars($product['stock']); ?></p>
                                    <p><b>Description:</b></p>
                                    <p><?php echo nl2br(htmlspecialchars($product['description'])); ?></p>
                                </div>
                            </div>
                            <br>
                            <div class="fb-comments"
                                data-href="http://localhost/final_caps/product.php?product=<?php echo urlencode($slug); ?>"
                                data-numposts="10" width="100%">
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <?php include 'includes/sidebar.php'; ?>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <?php include 'includes/footer.php'; ?>
    </div>

    <?php include 'includes/scripts.php'; ?>
    <script>
        $(function () {
            var maxStock = <?php echo (int) $product['stock']; ?>;

            if (maxStock == 0) {
                $('#addToCartBtn').attr('disabled', 'disabled').text('Out of Stock');
                $('#quantity').attr('disabled', 'disabled');
                $('#add').attr('disabled', 'disabled');
                $('#minus').attr('disabled', 'disabled');
            }

            $('#add').click(function (e) {
                e.preventDefault();
                var quantity = parseInt($('#quantity').val());
                if (quantity < maxStock) {
                    $('#quantity').val(quantity + 1);
                }
            });

            $('#minus').click(function (e) {
                e.preventDefault();
                var quantity = parseInt($('#quantity').val());
                if (quantity > 1) {
                    $('#quantity').val(quantity - 1);
                }
            });

            $('#productForm').submit(function (e) {
                e.preventDefault();
                if (maxStock == 0) {
                    alert('This product is out of stock.');
                    return;
                }
                // Submit form or AJAX code to add the product to the cart
                // Example: $.post('add_to_cart.php', $(this).serialize(), function(response) { ... });
            });
        });
    </script>
</body>

</html>