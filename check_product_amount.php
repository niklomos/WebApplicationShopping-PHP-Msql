<?php
include_once 'config.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

}

// รับข้อมูลตะกร้าสินค้าจาก Ajax
$cart = $_POST['cart'][$user_id];

// ตรวจสอบจำนวนสินค้าในตะกร้า
foreach ($cart as $cartItemID => $cartItem) {
    $productId = $cartItem['name'];
    $quantity = $cartItem['quantity'];

    // ดึงจำนวนสินค้าปัจจุบันจากฐานข้อมูล
    $productQuery = "SELECT product_amount FROM product WHERE id = $cartItemID";
    $productResult = $conn->query($productQuery);

    if ($productResult->num_rows > 0) {
        $productRow = $productResult->fetch_assoc();
        $currentStock = $productRow['product_amount'];

        // เช็คว่าจำนวนสินค้าที่จะสั่งซื้อมากกว่าจำนวนสินค้าในสต็อกหรือไม่
        if ($quantity > $currentStock) {
            // สินค้าไม่เพียงพอ
            echo json_encode(array('status' => 'error'));
            exit();
        }
    } else {
        // ไม่พบสินค้าในฐานข้อมูล
        echo json_encode(array('status' => 'error'));
        exit();
    }
}

// สินค้าเพียงพอ
echo json_encode(array('status' => 'success'));
?>
