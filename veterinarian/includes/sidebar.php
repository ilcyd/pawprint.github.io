<?php
// Function to normalize a URL
function normalize_url($url)
{
    return rtrim($url, '/');
}

// Define the base URL function (modify this as per your environment)
function base_url()
{
    return '/admin';
}

// Normalize the current page URL
$current_page = normalize_url($_SERVER['REQUEST_URI']);
$current_page = str_replace(base_url(), '', $current_page);

// Function to check if the current page matches any of the target links and return appropriate class
function is_active($target_urls)
{
    // Get the current URL without query parameters
    $current_url = rtrim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

    // Remove base URL from the current URL
    $current_url = str_replace(base_url(), '', $current_url);

    // Check if the current URL ends with any of the target URLs
    foreach ($target_urls as $target_url) {
        if (substr($current_url, -strlen($target_url)) === $target_url) {
            return 'active';
        }
    }
    return '';
}
?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="home.php" class="brand-link">
        <img src="../images/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">PawPrints</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="../images/<?php echo $user['profile'] ?>" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block"><?php echo $user['firstname'] . " " . $user['lastname']; ?></a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="home.php" class="nav-link <?php echo is_active(['/home.php']); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="category.php" class="nav-link <?php echo is_active(['/category.php']); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Appointments
                        </p>
                    </a>
                </li>
                
                <li class="nav-header">Record</li>

               
                        <li class="nav-item">
                            <a href="users.php" class="nav-link <?php echo is_active(['/users.php', '/pet_records.php', '/vaccine_app.php', '/vaccine_view.php', '/consultation_app.php', '/consultation_view.php' , '/admission_view.php']) ; ?>">
                                <i class="nav-icon fas fa-tachometer-alt"></i>

                                <p>Pet Health Record</p>
                            </a>
                        </li>
                       
                    
                </li>
                <!-- <li class="nav-header">Reports</li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link <?php echo is_active(['/sales_product.php', '/sales_category.php', '/sales.php']); ?>">
                        <i class="nav-icon fas fa-money-bill"></i>
                        <p>
                            Sales
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="sales_product.php"
                                class="nav-link <?php echo is_active(['/sales_product.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales by Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sales_category.php"
                                class="nav-link <?php echo is_active(['/sales_category.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales by Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="sales.php" class="nav-link <?php echo is_active(['/sales.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Total Sales</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="backup.php" class="nav-link <?php echo is_active(['/backup_database.php']); ?>">
                        <i class="nav-icon far fa-image"></i>
                        <p>Backup Database</p>
                    </a>
                </li> -->
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>