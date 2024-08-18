<?php 

require('config.php');

// Sanitize the input to prevent SQL injection
$id = mysqli_real_escape_string($conn, $_GET["idemp"]);

// Select the product by id
$sql_select = "SELECT * FROM register WHERE id = $id";
$result_select = mysqli_query($conn, $sql_select);

if ($result_select) {
    $row = mysqli_fetch_object($result_select);
    if ($row) {
        $user_id = mysqli_real_escape_string($conn, $row->id);

        // Check if the product is in any orders
        $sql_orders = "SELECT user_id FROM orders WHERE user_id = '$user_id'";
        $result_orders = mysqli_query($conn, $sql_orders);
       
        // Select the order products
    $sql_orders_cart = "SELECT user_id FROM orders_cart";
    $result_orders_cart = mysqli_query($conn, $sql_orders_cart);

      $is_deletable = true; // Flag to check if any product is not deletable
      while ($row2 = mysqli_fetch_object($result_orders_cart)) {
        $user_id_cart_array = explode(",", $row2->user_id);

        // Check each product name from the list against each product name in order_product
          foreach ( $user_id_cart_array as  $user_id_cart) {
            if ( $user_id == trim( $user_id_cart)) {
              $is_deletable = false;
              break 2; // Exit both loops if a match is found
            }
          }
        }
      
        if (mysqli_num_rows($result_orders) > 0 || !$is_deletable) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                  Swal.fire({
                    title: "ไม่สามารถลบแอคเคาท์นี้ได้",
                    text: "แอคเคาท์มีรายการสั่งซื้อกำลังดำเนินการอยู่",
                    icon: "warning",
                    confirmButtonText: "ตกลง"
                  }).then(function() {
                    window.location = "' . $_SERVER['HTTP_REFERER'] . '";
                  });
                });
              </script>';
            exit(0);
        } else {
            // Delete the product
            $sql_delete = "DELETE FROM register WHERE id = $id";
            $result_delete = mysqli_query($conn, $sql_delete);

            if ($result_delete) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit(0);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Product not found.<br>";
    }
} else {
    echo "Error: " . mysqli_error($conn) . "<br>";
}

?>
