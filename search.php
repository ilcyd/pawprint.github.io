<?php
include ('includes/session.php');
include ('includes/header.php');
include ('includes/navbar.php');

?>

<body class="hold-transition layout-top-nav sidebar-collapse">

    <div class="content-wrapper">
        <div class="container">

            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-sm-9">
                        <?php
                        $keyword = '%' . $_POST['keyword'] . '%';

                        // Count the number of rows matching the keyword
                        $stmt = $conn->prepare("SELECT COUNT(*) AS numrows FROM products WHERE name LIKE ?");
                        $stmt->bind_param("s", $keyword);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $row = $result->fetch_assoc();
                        if ($row['numrows'] < 1) {
                            echo '<h1 class="page-header">No results found for <i>' . $_POST['keyword'] . '</i></h1>';
                        } else {
                            echo '<h1 class="page-header">Search results for <i>' . $_POST['keyword'] . '</i></h1>';
                            $inc = 3;
                            $stmt = $conn->prepare("SELECT * FROM products WHERE name LIKE ?");
                            $stmt->bind_param("s", $keyword);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            while ($row = $result->fetch_assoc()) {
                                $highlighted = preg_filter('/' . preg_quote($_POST['keyword'], '/') . '/i', '<b>$0</b>', $row['name']);
                                $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
                                $inc = ($inc == 3) ? 1 : $inc + 1;
                                if ($inc == 1)
                                    echo "<div class='row'>";
                                echo "
                            <div class='col-sm-4'>
                                <a href='product.php?product=" . $row['slug'] . "'>
                                <div class='box box-solid'>
                                    <div class='box-body prod-body'>
                                        <img src='" . $image . "' width='100%' height='230px' class='thumbnail'>
                                        <h5>" . $highlighted . "</h5>
                                    </div>
                                    <div class='box-footer'>
                                        <b>&#8369; " . number_format($row['price'], 2) . "</b>
                                    </div>
                                </div>
                            </a>
                            </div>
                            ";
                                if ($inc == 3)
                                    echo "</div>";
                            }
                            if ($inc == 1)
                                echo "<div class='col-sm-4'></div><div class='col-sm-4'></div></div>";
                            if ($inc == 2)
                                echo "<div class='col-sm-4'></div></div>";
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

    <?php
    include 'includes/footer.php';
    include ('includes/appointment_modal.php');

    include 'includes/scripts.php';
    ?>
</body>

</html>