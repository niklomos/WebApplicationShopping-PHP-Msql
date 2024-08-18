<?php

require('config.php');

// Sanitize the input to prevent SQL injection
$id_array = $_POST["idcheckbox"];
$multiple_id = implode(",", $id_array);

// Select the product by id
$sql_select = "SELECT * FROM register WHERE id IN ($multiple_id)";
$result_select = mysqli_query($conn, $sql_select);

if ($result_select) {
    $user_id = []; // เก็บชื่อสินค้าที่ดึงมาได้
    while ($row = mysqli_fetch_object($result_select)) { // ใช้ while เพื่อดึงข้อมูลทั้งหมด
        $user_id[] = mysqli_real_escape_string($conn, $row->id); // เพิ่มชื่อสินค้าลงใน array
    }

    if (!empty($user_id)) {
        // แยกชื่อสินค้าจาก product_name_list
        $user_id_list = implode(",", $user_id);
        $user_id_array = explode(",", $user_id_list);



        // Select the order products
        $sql_orders = "SELECT user_id FROM orders_cart";
        $result_orders = mysqli_query($conn, $sql_orders);

        // Select the order products
        $sql_orders2 = "SELECT user_id FROM orders";
        $result_orders2 = mysqli_query($conn, $sql_orders2);


        if ($result_orders || $result_orders2) {
            $is_deletable = true; // Flag to check if any product is not deletable
            while ($row = mysqli_fetch_object($result_orders)) {
                $user_id_order_array = explode(",", $row->user_id);

                // Check each product name from the list against each product name in order_product
                foreach ($user_id_array as $user_id) {
                    foreach ($user_id_order_array as  $user_id_order) {
                        if (trim($user_id) == trim($user_id_order)) {
                            $is_deletable = false;
                            break 2; // Exit both loops if a match is found
                        }
                    }
                }
            }

            $is_deletable2 = true; // Flag to check if any product is not deletable
            while ($row2 = mysqli_fetch_object($result_orders2)) {
                $user_id_order_array2 = explode(",", $row2->id);

                // Check each product name from the list against each product name in order_product
                foreach ($user_id_array as $user_id) {
                    foreach ($user_id_order_array2 as  $user_id_order2) {
                        if (trim($user_id) == trim($user_id_order2)) {
                            $is_deletable = false;
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
                        title: "ไม่สามารถลบแอคเคาท์ได้",
                        text: "มีบางแอคเคาท์ที่มีรายการสั่งซื้อกำลังดำเนินการอยู่",
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
                $sql_delete = "DELETE FROM register WHERE id IN ($multiple_id)";
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
