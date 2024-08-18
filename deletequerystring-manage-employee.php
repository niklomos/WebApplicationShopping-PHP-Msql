<?php

require('config.php');
$id = $_GET["idemp"];

$sql_select = "SELECT level FROM employee WHERE id=$id";
$result = mysqli_query($conn, $sql_select);
$row = mysqli_fetch_object($result);

if ($row->level == 'A') {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
        document.addEventListener("DOMContentLoaded", function() {
          Swal.fire({
            title: "ไม่สามารถลบผู้ดูแลระบบได้ ",
            text: "กรุณาเปลี่ยนสถานะของแอคเคาท์ก่อน",
            icon: "warning",
            confirmButtonText: "ตกลง"
          }).then(function() {
            window.location = "' . $_SERVER['HTTP_REFERER'] . '";
          });
        });
      </script>';
    exit(0);
} else {
    $sql = "DELETE FROM employee WHERE id=$id";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        header('location: ' . $_SERVER['HTTP_REFERER']);
        exit(0);
    } else {
        echo mysqli_error($conn);
    }
}
