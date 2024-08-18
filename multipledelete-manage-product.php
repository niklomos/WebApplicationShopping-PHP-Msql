<?php

require('config.php');

// Sanitize the input to prevent SQL injection
$id_array = $_POST["idcheckbox"];
$mutiple_id = implode(",", $id_array);

// Select the product by id
$sql_select = "SELECT * FROM product WHERE id IN ($mutiple_id)";
$result_select = mysqli_query($conn, $sql_select);

if ($result_select) {
  $product_ids = []; // เก็บชื่อสินค้าที่ดึงมาได้
  while ($row = mysqli_fetch_object($result_select)) { // ใช้ while เพื่อดึงข้อมูลทั้งหมด
    $product_ids[] = mysqli_real_escape_string($conn, $row->id); // เพิ่มชื่อสินค้าลงใน array
  }

  if (!empty($product_ids)) {
    // แยกชื่อสินค้าจาก product_name_list
    $product_ids_list = implode(",", $product_ids);
    $product_ids_array = explode(",", $product_ids_list);



    // Select the order products
    $sql_orders = "SELECT pro_id FROM orders_cart";
    $result_orders = mysqli_query($conn, $sql_orders);

     // Select the order products
     $sql_orders2 = "SELECT pro_id FROM orders";
     $result_orders2 = mysqli_query($conn, $sql_orders2);


    if ($result_orders || $result_orders2) {
      $is_deletable = true; // Flag to check if any product is not deletable
      while ($row = mysqli_fetch_object($result_orders)) {
        $product_id_array = explode(",", $row->pro_id);

        // Check each product name from the list against each product name in order_product
        foreach ($product_ids_array as $product_id) {
          foreach ( $product_id_array as  $product_id_order) {
            if (trim($product_id) == trim( $product_id_order)) {
              $is_deletable = false;
              break 2; // Exit both loops if a match is found
            }
          }
        }
      }
      
      $is_deletable2 = true; // Flag to check if any product is not deletable
      while ($row2 = mysqli_fetch_object($result_orders2)) {
        $product_id_array2 = explode(",", $row2->pro_id);

        // Check each product name from the list against each product name in order_product
        foreach ($product_ids_array as $product_id) {
          foreach ($product_id_array2 as  $product_id_order2) {
            if (trim($product_id) == trim( $product_id_order2)) {
                            $is_deletable2 = false;
              break 2; // Exit both loops if a match is found
            }
          }
        }
      }



      if (!$is_deletable || !$is_deletable2) {
        echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
        echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                      Swal.fire({
                        title: "ไม่สามารถลบสินค้าได้",
                        text: "มีสินค้าบางชิ้นที่มีรายการสั่งซื้อกำลังดำเนินการอยู่",
                        icon: "warning",
                        confirmButtonText: "ตกลง"
                      }).then(function() {
                        window.location = "' . $_SERVER['HTTP_REFERER'] . '";
                      });
                    });
                  </script>';

        exit(0);
      } else {

        // Delete the products
        $sql_delete = "DELETE FROM product WHERE id IN ($mutiple_id)";
        $result_delete = mysqli_query($conn, $sql_delete);

        if ($result_delete) {
          header('Location: ' . $_SERVER['HTTP_REFERER']);
          exit(0);
        } else {
          echo "Error: " . mysqli_error($conn);
        }
      }
    } else {
      echo "Error: " . mysqli_error($conn) . "<br>";
    }
  } else {
    echo "Product not found.<br>";
  }
} else {
  echo "Error: " . mysqli_error($conn) . "<br>";
}
