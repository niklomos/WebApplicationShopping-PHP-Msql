<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- เรียกใช้ Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <script src="./js/bootstrap.min.js"></script>
    <!-- เรียกใช้ FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <title>Document</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand text-white" href="#">BSRU SHOP</a>

        <!-- เมื่อขนาดหน้าจอเล็กลง ให้แสดงไอคอนที่อยู่และไอคอนตะกร้า -->
        <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbar1">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar1" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-light"><i class="fas fa-map-marker-alt mr-2"></i>ที่อยู่</a>
                </li>
                <li class="nav-item me-5">
                    <a href="cart.php" class="nav-link text-light"><i class="fas fa-shopping-cart mr-2"></i>ตะกร้า</a>
                </li>
            </ul>
        </div>
    </nav>
    <?php
    session_start();

    if (isset($_GET['id'])) {
        $productId = $_GET['id'];

        // ตรวจสอบว่ามีข้อมูลตะกร้าใน session หรือไม่
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
            $cart = $_SESSION['cart'];

            // สร้างตะกร้าใหม่ที่จะเก็บรายการสินค้าที่ไม่ถูกยกเลิก
            $newCart = [];

            // ลบรายการสินค้าที่มี id ตรงกับที่ระบุออกจากตะกร้า
            foreach ($cart as $key => $item) {
                if ($item['id'] != $productId) {
                    $newCart[] = $item; // เพิ่มรายการสินค้าที่ไม่ถูกยกเลิกเข้าในตะกร้าใหม่
                }
            }

            // อัปเดต session ใหม่ด้วยตะกร้าใหม่ที่ไม่มีรายการที่ถูกยกเลิก
            $_SESSION['cart'] = $newCart;
        }
    }

    // หลังจากยกเลิกแล้วให้กลับไปยังหน้าตะกร้า
    header("Location: cart.php");
    ?>