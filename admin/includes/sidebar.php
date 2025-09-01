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
                <span class="d-block">
                    <?php echo htmlspecialchars($user['firstname'] . " " . $user['lastname']); ?>
                    <span class="online-indicator ml-2 bg-success"></span>
                </span>
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
                <li class="nav-header">Manage</li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link <?php echo is_active(['/products.php', '/category.php', '/subcategory.php']); ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Inventory
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="products.php" class="nav-link <?php echo is_active(['/products.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="category.php" class="nav-link <?php echo is_active(['/category.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="subcategory.php" class="nav-link <?php echo is_active(['/subcategory.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sub Category</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="services.php" class="nav-link <?php echo is_active(['/services.php']); ?>">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            Services
                        </p>
                    </a>

                </li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link <?php echo is_active(['/transaction.php', '/users_registered.php']); ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Transactions
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="transaction.php" class="nav-link <?php echo is_active(['/transaction.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Service Transactions</p>
                            </a>
                        </li>
                        <li class="nav-item has-treeview">
                            <a href="#"
                                class="nav-link <?php echo is_active(['/product_transact.php', '/product_invoice.php']); ?>">
                                <i class="nav-icon fas fa-box"></i> <!-- Icon for Product Transactions -->
                                <p>
                                    Product Transactions
                                    <i class="right fas fa-angle-left"></i> <!-- Dropdown arrow -->
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="product_transact.php"
                                        class="nav-link <?php echo is_active(['/product_transact.php']); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product Transactions</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="product_invoice.php"
                                        class="nav-link <?php echo is_active(['/product_invoice.php']); ?>">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Product Invoice</p>
                                    </a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#"
                        class="nav-link <?php echo is_active(['/users.php', '/users_registered.php', '/users_denied.php']); ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="users.php" class="nav-link <?php echo is_active(['/users.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Pending Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="users_registered.php"
                                class="nav-link <?php echo is_active(['/users_registered.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Registered Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="users_denied.php" class="nav-link <?php echo is_active(['/users_denied.php']); ?>">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Denied Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="veterinarians.php"
                        class="nav-link <?php echo is_active(['/users.php', '/users_registered.php', '/users_denied.php']); ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            Doctors
                        </p>
                    </a>
                </li>
                <li class="nav-header">Reports</li>
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
                                <p>Sales in Services</p>
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
                    <a href="feedback.php" class="nav-link <?php echo is_active(['/feedback.php']); ?>">
                        <i class="nav-icon far fa-image"></i>
                        <p>Feedback</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="backup.php" class="nav-link <?php echo is_active(['/backup_database.php']); ?>">
                        <i class="nav-icon far fa-image"></i>
                        <p>Backup Database</p>
                    </a>
                </li>
                <li class="nav-header">Settings</li>
                <li class="nav-item">
                    <a href="settings.php" class="nav-link <?php echo is_active(['/settings.php']); ?>">
                        <i class="nav-icon fas fa-wrench"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>