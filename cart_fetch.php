<?php
include 'includes/session.php';

$output = array('list' => '', 'count' => 0);

if (isset($user['id'])) {
  try {
    $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM cart LEFT JOIN products ON products.id = cart.product_id LEFT JOIN category ON category.id = products.category_id WHERE user_id = ?");
    $stmt->bind_param("i", $user['id']);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
      // Ensure quantity does not exceed stock
      $quantity = min($row['quantity'], $row['stock']);

      $output['count']++;
      $image = (!empty($row['photo'])) ? 'images/' . $row['photo'] : 'images/noimage.jpg';
      $productname = (strlen($row['prodname']) > 30) ? substr_replace($row['prodname'], '...', 27) : $row['prodname'];
      $output['list'] .= "
          <a href='product.php?product=" . $row['slug'] . "' class='dropdown-item'>
            <div class='media'>
              <img src='" . $image . "' class='img-size-50 mr-3 ' alt='Product Image'>
              <div class='media-body'>
                <h3 class='dropdown-item-title'>
                  " . $row['catname'] . "
                  <span class='float-right text-sm text-secondary'>&times; " . $quantity . "</span>
                </h3>
                <p class='text-sm'>" . $productname . "</p>
              </div>
            </div>
          </a>";
    }
  } catch (Exception $e) {
    $output['message'] = $e->getMessage();
  }
} else {
  if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
  }

  if (empty($_SESSION['cart'])) {
    $output['count'] = 0;
  } else {
    foreach ($_SESSION['cart'] as $row) {
      $output['count']++;
      $stmt = $conn->prepare("SELECT *, products.name AS prodname, category.name AS catname FROM products LEFT JOIN category ON category.id = products.category_id WHERE products.id = ?");
      $stmt->bind_param("i", $row['productid']);
      $stmt->execute();
      $result = $stmt->get_result();
      $product = $result->fetch_assoc();

      // Ensure quantity does not exceed stock
      $quantity = min($row['quantity'], $product['stock']);

      $image = (!empty($product['photo'])) ? 'images/' . $product['photo'] : 'images/noimage.jpg';
      $productname = (strlen($product['prodname']) > 30) ? substr_replace($product['prodname'], '...', 27) : $product['prodname'];
      $output['list'] .= "
          <a href='product.php?product=" . $product['slug'] . "' class='dropdown-item'>
            <div class='media'>
              <img src='" . $image . "' class='img-size-50 mr-3 ' alt='Product Image'>
              <div class='media-body'>
                <h3 class='dropdown-item-title'>
                  " . $product['catname'] . "
                  <span class='float-right text-sm text-secondary'>&times; " . $quantity . "</span>
                </h3>
                <p class='text-sm'>" . $productname . "</p>
              </div>
            </div>
          </a>";
    }
  }
}

echo json_encode($output);