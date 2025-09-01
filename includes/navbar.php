<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul id="left-navbar" class="navbar-nav">
    <li class="nav-item d-inline-block d-sm-none">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index.php" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="contact_us.php" class="nav-link">Contact Us</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="about_us.php" class="nav-link">About Us</a>
    </li>
    <!-- Your category dropdown code here -->
    <li class="nav-item d-none d-sm-inline-block dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Category
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php
        $sql = "SELECT * FROM category";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<a class="dropdown-item" href="category.php?category=' . $row['cat_slug'] . '">' . $row['name'] . '</a>';
          }
        } else {
          echo '<a class="dropdown-item" href="#">No categories found</a>';
        }
        ?>
      </div>
    </li>
    <!-- <li class="nav-item d-none d-sm-inline-block dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
        aria-haspopup="true" aria-expanded="false">
        Services
      </a>
      <div class="dropdown-menu" aria-labelledby="navbarDropdown">
        <?php
        $sql = "SELECT * FROM services";
        $result = mysqli_query($conn, $sql);
        $count = mysqli_num_rows($result);
        if ($count > 0) {
          while ($row = mysqli_fetch_assoc($result)) {
            echo '<a class="dropdown-item" href="#">' . $row['service_name'] . " &#8369;" . $row['price'];
            '</a>';
          }
        } else {
          echo '<a class="dropdown-item" href="#">No services found</a>';
        }
        ?>
      </div>
    </li> -->
    <?php if (isset($_SESSION['user'])): ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="pets.php" class="nav-link">Your Pets</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="calendar.php" class="nav-link">
          Set Appointment
        </a>
      </li>
    <?php endif; ?>



  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <li class="nav-item">
      <a class="nav-link" data-widget="navbar-search" href="#" role="button">
        <i class="fas fa-search"></i>
      </a>
      <div class="navbar-search-block">
        <form class="form-inline" method="POST" action="search.php">
          <div class="input-group input-group-sm">
            <input class="form-control form-control-navbar" type="search" name="keyword" placeholder="Search Product"
              aria-label="Search">
            <div class="input-group-append">
              <button class="btn btn-navbar" type="submit">
                <i class="fas fa-search"></i>
              </button>
              <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </form>
      </div>
    </li>
    <!-- Cart -->
    <li class="nav-item dropdown">
      <a class="nav-link" href="#" data-toggle="dropdown">
        <i class="fas fa-shopping-cart"></i> <span class="badge badge-primary cart_count"></span>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right cart-dropdown">
        <span class="dropdown-item dropdown-header">You have <span class="cart_count"></span> item(s) in cart</span>
        <div id="cart_menu">
          <!-- Cart items will be populated here dynamically -->
        </div>
        <div class="dropdown-divider"></div> <!-- Divider -->
        <a class="dropdown-item text-center" href="cart_view.php">Go to Cart</a>
      </div>
    </li>





    <?php if (isset($_SESSION['user'])): ?>
      <!-- Messages Dropdown Menu -->

      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" id="notify-btn" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="show_notif"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notify-menu">
          <!-- Notifications will be dynamically inserted here -->
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <img src="images/<?php echo $user['profile'] ?>" class="rounded-circle" style="width: 26px; height: 26px;"
            alt="User Image">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="userDropdown">
          <!--begin::User Image-->
          <div class="dropdown-header bg-primary text-white text-center">
            <img src="images/<?php echo $user['profile'] ?>" class="rounded-circle" style="width: 50px; height: 50px;"
              alt="User Image">
            <p class="mt-2 mb-0"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?> -
              <?php echo $user['type'] == 0 ? 'Pet Owner' : 'Other'; ?>
            </p>
            <small>Member since <?php echo date('Y-m-d', strtotime($user['date_created'])); ?></small>
          </div>
          <!--end::User Image-->
          <!--begin::Menu Body-->

          <!--end::Menu Body-->
          <!--begin::Menu Footer-->
          <div class="dropdown-divider"></div>
          <a href="profile.php" class="dropdown-item btn btn-default btn-flat">Profile</a>
          <a href="appointments.php" class="dropdown-item btn btn-default btn-flat">Appointments</a>
          <a href="logout.php" class="dropdown-item btn btn-default btn-flat float-right">Sign out</a>
          <!--end::Menu Footer-->
        </div>
      </li>
    <?php else: ?>
      <li><a href="login.php" class="nav-link">LOGIN</a></li>
      <li><a href="signup.php" class="nav-link">SIGNUP</a></li>
    <?php endif; ?>
  </ul>
</nav>
    <?php if (isset($_SESSION['user'])): ?>
<script>
  const notify_btn = document.getElementById('notify-btn');
  const notify_label = document.getElementById('show_notif');
  const notify_container = document.getElementById('notify-menu');
  let xhr = new XMLHttpRequest();

  function notify_me() {
    xhr.open('GET', 'select.php', true);
    xhr.send();

    xhr.onload = function () {
      if (xhr.status == 200) {
        let get_data = JSON.parse(xhr.responseText);
        notify_label.textContent = get_data;
        if (get_data > 0) {
          notify_label.classList.remove('badge-warning');
          notify_label.classList.add('badge-warning');
        } else {
          notify_label.classList.remove('badge-warning');
          notify_label.classList.add('badge-warning');
        }
      }
    }
  }

  function markAsRead() {
    xhr.open('GET', 'mark_as_read.php', true);
    xhr.send();
  }

  function updateNotifications() {
    xhr.open('GET', 'data.php', true);
    xhr.send();
    xhr.onload = function () {
      if (xhr.status == 200) {
        let data = JSON.parse(xhr.responseText);
        if (notify_container.classList.contains('show')) {
          notify_container.innerHTML = '';
          if (data.length > 0) {
            data.forEach(notification => {
              let notificationsHTML = '';

              data.forEach(notification => {
                notificationsHTML += `
    <a href="appointments.php" class="dropdown-item">
      <span>
        <i class="fas fa-envelope mr-2"></i>${notification.msg}
      </span>
      <span class="float-right text-muted text-sm">${notification.created_at}</span>
    </a>
    <div class="dropdown-divider"></div>`;
              });

              // Add the "Clear Notifications" link after all notifications
              notificationsHTML += `
  <a href="clear_notifications.php" class="dropdown-item">
    Clear Notifications
  </a>`;

              // Update the container's innerHTML once
              notify_container.innerHTML = notificationsHTML;

            });
          } else {
            notify_container.innerHTML = '<p class="dropdown-item">No notifications</p>';
          }
        }
      }
    }
  }

  window.onload = function () {
    notify_me();
    updateNotifications();
    setInterval(notify_me, 1000);
    setInterval(updateNotifications, 1050);

    document.addEventListener('click', function (event) {
      const isClickInsideDropdown = notify_container.contains(event.target);
      const isClickOnNotifyButton = notify_btn.contains(event.target);
      if (!isClickInsideDropdown && !isClickOnNotifyButton) {
        notify_container.classList.remove('show');
      }
    });
  }
  // Call markAsRead function when the notify button is clicked
  notify_btn.addEventListener('click', (e) => {
    e.preventDefault();
    markAsRead();
  });
    <?php endif; ?>

</script>
<!-- /.navbar -->

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index.php" class="brand-link">
    <img src="images/logo.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">PawPrints</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Home -->
        <li class="nav-item">
          <a href="index.php" class="nav-link">
            <i class="nav-icon fas fa-home"></i>
            <p>Home</p>
          </a>
        </li>
        <!-- Contact -->
        <li class="nav-item">
          <a href="contact_us.php" class="nav-link">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Contact Us</p>
          </a>
        </li>
        <!-- About Us -->
        <li class="nav-item">
          <a href="about_us.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>About Us</p>
          </a>
        </li>
        <!-- Category Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
            <i class="nav-icon fas fa-list"></i>
            <span>Category</span>
          </a>
          <div class="dropdown-menu bg-dark" aria-labelledby="navbarDropdown">
            <!-- PHP code for category dropdown -->
            <?php
            $sql = "SELECT * FROM category";
            $result = mysqli_query($conn, $sql);
            $count = mysqli_num_rows($result);
            if ($count > 0) {
              while ($row = mysqli_fetch_assoc($result)) {
                echo '<a class="dropdown-item" href="category.php?category=' . $row['cat_slug'] . '">' . $row['name'] . '</a>';
              }
            } else {
              echo '<a class="dropdown-item" href="#">No categories found</a>';
            }
            ?>
          </div>
        </li>
        <!-- About Us -->
        <li class="nav-item">
          <a href="pets.php" class="nav-link">
            <i class="nav-icon fas fa-users"></i>
            <p>Your Pets</p>
          </a>
        </li>
        <!-- About Us -->
        <li class="nav-item d-none d-sm-inline-block">
          <a href="#set" class="nav-link" data-toggle="modal">
            Set Appointment
          </a>
        </li>

      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>