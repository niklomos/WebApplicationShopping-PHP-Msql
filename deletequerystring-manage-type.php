<?php 

require('config.php');

// Sanitize the input to prevent SQL injection
$id = mysqli_real_escape_string($conn, $_GET["idemp"]);

// Select the product by id
$sql_select = "SELECT * FROM type WHERE id = $id";
$result_select = mysqli_query($conn, $sql_select);

if ($result_select) {
    $row = mysqli_fetch_object($result_select);
    if ($row) {
        $typ_id = mysqli_real_escape_string($conn, $row->id);

        // Check if the product is in any orders
        $sql_product = "SELECT typ_id FROM product WHERE typ_id = '$typ_id'";
        $result_product = mysqli_query($conn, $sql_product);
       
        
      
        if (mysqli_num_rows($result_product) > 0 ) {
            echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
            echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                  Swal.fire({
                    title: "ไม่สามารถลบประเภทสินค้านี้ได้",
                    text: "ประเภทสินค้านี้มีรายการสินค้าใช้อยู่",
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
            $sql_delete = "DELETE FROM type WHERE id = $id";
            $result_delete = mysqli_query($conn, $sql_delete);

            if ($result_delete) {
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit(0);
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        }
    } else {
        echo "TypeName not found.<br>";
    }
} else {
    echo "Error: " . mysqli_error($conn) . "<br>";
}

?>
