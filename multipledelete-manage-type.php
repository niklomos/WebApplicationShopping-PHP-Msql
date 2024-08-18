<?php

require('config.php');

// Sanitize the input to prevent SQL injection
$id_array = $_POST["idcheckbox"];
$multiple_id = implode(",", $id_array);



// Select the product by id
$sql_select = "SELECT * FROM type WHERE id IN ($multiple_id)";
$result_select = mysqli_query($conn, $sql_select);


if ($result_select) {
    $type_ids = []; // เก็บชื่อสินค้าที่ดึงมาได้
    while ($row = mysqli_fetch_object($result_select)) { // ใช้ while เพื่อดึงข้อมูลทั้งหมด
        $type_ids[] = mysqli_real_escape_string($conn, $row->id); // เพิ่มชื่อสินค้าลงใน array
    }

    $delete_ids_list = implode(",", $type_ids);
    $delete_ids_array = explode(",",  $delete_ids_list);

    // Select the order products
    $sql_product = "SELECT typ_id FROM product";
    $result_product = mysqli_query($conn, $sql_product);

    if ($result_product) {
        $is_deletable = true; // Flag to check if any product is not deletable
        while ($row = mysqli_fetch_object($result_product)) {

            $type_id_array = explode(",", $row->typ_id);

            // Check each product name from the list against each product name in order_product
            foreach ($delete_ids_array as $type_ids) {
                foreach ($type_id_array as $type_id_product) {
                    if (trim($type_ids) == trim($type_id_product)) {
                        $is_deletable = false;
                        break 2; // Exit both loops if a match is found
                    }
                }
            }
        }

        if (!$is_deletable) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                    document.addEventListener("DOMContentLoaded", function() {
                      Swal.fire({
                        title: "ไม่สามารถลบประเภทสินค้าได้",
                        text: "มีประเภทสินค้าบางรายการที่มีสินค้ากำลังใช้งานอยู่",
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
            $sql_delete = "DELETE FROM type WHERE id IN ($multiple_id)";
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
    echo "Error: " . mysqli_error($conn) . "<br>";
}
