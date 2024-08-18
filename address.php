<?php
include_once 'config.php';
session_start();

// ตรวจสอบ Session หากมี ID ผู้ใช้ที่เข้าสู่ระบบ
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
    $query = "SELECT * FROM register WHERE id = $user_id";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $username_user = $row['username'];
        $fullname = $row['full_name'];
        $phone = $row['phone'];
        $address = $row['address'];
    }
} else {
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    echo '<script>
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        title: "กรุณาสมัครสมาชิก",
                        icon: "warning"
                    }).then(function() {
                        window.location = "index.php";
                    });
                });
            </script>';
}

// ตรวจสอบการส่งค่าแบบ POST จากฟอร์ม
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าที่อยู่ใหม่จากฟอร์ม
    $new_fullname = $_POST['new_fullname'];
    $new_phone = $_POST['new_phone'];
    $new_address = $_POST['new_address'];

    // อัปเดตข้อมูลที่อยู่ใหม่ลงในฐานข้อมูล
    $update_query = "UPDATE register SET full_name = '$new_fullname', phone = '$new_phone', address = '$new_address' WHERE id = $user_id";
    if ($conn->query($update_query) === TRUE) {
        // อัปเดตสำเร็จ
        $fullname = $new_fullname;
        $phone = $new_phone;
        $address = $new_address;
    } else {
        // อัปเดตไม่สำเร็จ
        echo "Error updating record: " . $conn->error;
    }
}
?>


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
    <link rel="stylesheet" href="./style-index.css">

    <title>ที่อยู่</title>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark  nav-search ">
        <a class="navbar-brand text-white" href="index.php">BSRU SHOP</a>

        <!-- เมื่อขนาดหน้าจอเล็กลง ให้แสดงไอคอนที่อยู่และไอคอนตะกร้า -->
        <button class="navbar-toggler ml-auto" data-bs-toggle="collapse" data-bs-target="#navbar1">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div id="navbar1" class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="index.php" class="nav-link text-light"><i class="fas fa-user mr-2"></i><?php echo $username_user; ?></a>
                </li>
                <li class="nav-item">
                    <a href="address.php" class="nav-link text-light"><i class="fas fa-map-marker-alt mr-2"></i>ที่อยู่</a>
                </li>
                <li class="nav-item ">
                    <a href="cart.php" class="nav-link text-light"><i class="fa-solid fa-cart-plus mr-2"></i>ตะกร้า</a>
                </li>
                <li class="nav-item ">
                    <a href="myorder-check.php" class="nav-link text-light">
                        <i class="fa-solid fa-truck-fast mr-2"></i>คำสั่งซื้อ
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <button class="btn  text-light dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-cog text-light" aria-hidden="true"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-dark btn-color text-light">
                        <li><a class="dropdown-item" href="manage-personal.php">จัดการข้อมูลส่วนตัว<i class="fa-solid fa-user-pen ms-1"></i></a></li>
                        <li><a class="dropdown-item" href="myorder-successful.php">การซื้อของฉัน<i class="fa-brands fa-shopify ms-1"></i></a></li>
                        <li><a class="dropdown-item " href="favorite.php">รายการโปรด<i class="fa-solid fa-heart ms-1"></i></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>

    <!-- ส่วนเนื้อหาหน้าที่อยู่ -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6 justify-content-center">
                <a href=" " class=" btn btn-color rounded-pill mb-3 b-product text-light" style="width:12rem"><b>ข้อมูลที่อยู่</b></a>

                <div class="card mb-3 border-dark b-product" style="width: 100%">
                    <div class="card-body">
                        <h6>ชื่อ: <?php echo $fullname; ?></h6>
                        <h6>เบอร์โทรศัพท์:<?php echo $phone; ?></h6>
                        <h6>ที่อยู่:<?php echo $address; ?></h6>
                    </div>
                </div>
                <!-- แสดงฟอร์มเพื่อแก้ไขที่อยู่ -->
                <a href=" " class=" btn btn-color rounded-pill mb-3 b-product text-light" style="width:12rem"><b>แก้ไขข้อมูลที่อยู่</b></a>
                <form method="post">
                    <div class="form-group">
                        <label for="new_fullname">ชื่อ:</label>
                        <input type="text" class="form-control b-product" id="new_fullname" name="new_fullname" value="<?php echo $fullname; ?>">
                    </div>
                    <div class="form-group">
                        <label for="new_phone">เบอร์โทรศัพท์:</label>
                        <input type="text" class="form-control b-product" id="new_phone" name="new_phone" value="<?php echo $phone; ?>">
                    </div>

                    <div class="form-group">
                        <label for="new_address">ที่อยู่:</label>
                        <textarea class="form-control b-product" id="new_address" name="new_address" rows="4"><?php echo $address; ?></textarea>
                    </div>

                    <button type="submit" class="btn btn-primary b-product">บันทึก</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>