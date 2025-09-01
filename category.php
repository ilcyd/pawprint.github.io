<?php
include ('includes/header.php');
include ('includes/session.php');

$slug = $_GET['category'];

try {
    $stmt = $conn->prepare("SELECT * FROM category WHERE cat_slug = ? AND delete_flag=0");
    $stmt->bind_param("s", $slug);
    $stmt->execute();
    $result = $stmt->get_result();
    $cat = $result->fetch_assoc();
    $catid = $cat['id'];
} catch (Exception $e) {
    echo "There is some problem in connection: " . $e->getMessage();
}

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
                <section class="content">
                    <div class="row">
                        <div class="col-sm-9">
                            <h1 class="page-header"><?php echo $cat['name']; ?></h1>
                            <?php

                            try {
                                $inc = 3;
                                $stmt = $conn->prepare("SELECT * FROM products WHERE category_id = ? AND delete_flag = 0");
                                $stmt->bind_param("i", $catid);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                while ($row = $result->fetch_assoc()) {
                                    $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
                                    $inc = ($inc == 3) ? 1 : $inc + 1;
                                    if ($inc == 1)
                                        echo "<div class='row'>";
                                    echo "
                                    <div class='col-sm-4'>
                                        <div class='box box-solid'>
                                            <div class='box-body prod-body'>
                                                <a href='product.php?product=" . $row['slug'] . "'><img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
                                                <h5>" . $row['name'] . "</a></h5>
                                            </div>
                                            <div class='box-footer'>
                                                <b>&#8369; " . number_format($row['price'], 2) . "</b>
                                            </div>
                                        </div>
                                    </div>
                                ";
                                    if ($inc == 3)
                                        echo "</div>";
                                }
                                if ($inc == 1)
                                    echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
                                if ($inc == 2)
                                    echo "<div class='col-sm-4'></div></div>";
                            } catch (Exception $e) {
                                echo "There is some problem in connection: " . $e->getMessage();
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
</body>

</html>