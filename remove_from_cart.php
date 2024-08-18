<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
        $product_id_to_remove = $_POST['product_id'];

        // ตรวจสอบว่าสินค้านี้มีอยู่ในตะกร้าของผู้ใช้หรือไม่
        if (isset($_SESSION['cart'][$user_id][$product_id_to_remove])) {
            // ลบสินค้าออกจากตะกร้า
            unset($_SESSION['cart'][$user_id][$product_id_to_remove]);
            echo "ลบสินค้าออกจากตะกร้าเรียบร้อยแล้ว";
            echo '<script>window.location.href = "cart.php";</script>';
            session_write_close();
        } else {
            echo "ไม่พบสินค้าในตะกร้า";
        }
    } else {
        echo "คำขอไม่ถูกต้อง";
    }
} else {
    echo "ผู้ใช้ไม่ได้เข้าสู่ระบบ";
}
?>
