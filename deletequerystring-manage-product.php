<?php 

require('config.php');

// Sanitize the input to prevent SQL injection
$id = mysqli_real_escape_string($conn, $_GET["idemp"]);

// Select the product by id
$sql_select = "SELECT * FROM product WHERE id = $id";
$result_select = mysqli_query($conn, $sql_select);

if ($result_select) {
    $row = mysqli_fetch_object($result_select);
    if ($row) {
        $product_id = mysqli_real_escape_string($conn, $row->id);

        // Check if the product is in any orders
        $sql_orders = "SELECT pro_id FROM orders WHERE pro_id = '$product_id'";
        $result_orders = mysqli_query($conn, $sql_orders);
       
        // Select the order products
    $sql_orders_cart = "SELECT pro_id FROM orders_cart";
    $result_orders_cart = mysqli_query($conn, $sql_orders_cart);

      $is_deletable = true; // Flag to check if any product is not deletable
      while ($row2 = mysqli_fetch_object($result_orders_cart)) {
        $product_id_array = explode(",", $row2->pro_id);

        // Check each product name from the list against each product name in order_product
          foreach ($product_id_array as $product_id_cart) {
            if ($product_id == trim($product_id_cart)) {
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
                    title: "ไม่สามารถลบสินค้านี้ได้",
                    text: "สินค้านี้มีรายการสั่งซื้อกำลังดำเนินการอยู่",
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
            $sql_delete = "DELETE FROM product WHERE id = $id";
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
