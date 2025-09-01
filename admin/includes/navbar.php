<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- Navbar Search -->
    <!-- <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline" method="POST" action="search.php">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" name="keyword" placeholder="Search" aria-label="Search">
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
      </li> -->
    <?php if (isset($_SESSION['admin'])): ?>

      <!-- Messages Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
            <!-- <div class="media">
              <img src="../dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> -->
            <!-- Message End -->
          <!-- </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
            <!-- <div class="media">
              <img src="../dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> -->
            <!-- Message End -->
          <!-- </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item"> -->
            <!-- Message Start -->
            <!-- <div class="media">
              <img src="../dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div> -->
            <!-- Message End -->
          <!-- </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li> -->
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" id="notify-btn" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge" id="show_notif"></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="notify-menu"> -->
          <!-- Notifications will be dynamically inserted here -->
        <!-- </div>
      </li> -->

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
          aria-haspopup="true" aria-expanded="false">
          <img src="../images/<?php echo $user['profile'] ?>" class="rounded-circle" style="width: 26px; height: 26px;"
            alt="User Image">
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="userDropdown">
          <!--begin::User Image-->
          <div class="dropdown-header bg-primary text-white text-center">
            <img src="../images/<?php echo $user['profile'] ?>" class="rounded-circle" style="width: 50px; height: 50px;"
              alt="User Image">
            <p class="mt-2 mb-0"><?php echo htmlspecialchars($user['firstname'] . ' ' . $user['lastname']); ?> -
              <?php echo $user['type'] == 2 ? 'Admin' : 'Other'; ?>
            </p>
            <small>Member since <?php echo date('Y-m-d', strtotime($user['date_created'])); ?></small>
          </div>
          <!--end::User Image-->
          <!--begin::Menu Body-->

          <!--end::Menu Body-->
          <!--begin::Menu Footer-->
          <div class="dropdown-divider"></div>
          <a href="#profile" data-toggle="modal" class="dropdown-item btn btn-default btn-flat"
            id="admin_profile">Update</a>
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
<?php include 'includes/profile_modal.php'; ?>


<!-- <script>
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
    <a href="users.php" class="dropdown-item">
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


</script> -->
<!-- /.navbar -->