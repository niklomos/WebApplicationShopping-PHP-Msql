<?php
require('config.php');
$id = $_GET["id"];

$sql = "SELECT * FROM report_successful_order WHERE id=$id";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DETAIL-REPORT-ORDERS</title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <?php
    include_once 'includeCSS.php';
    include_once 'includeJS.php';
    includeJS();
    includeCSS();
    include_once 'navbar_function.php';
    include_once 'sidebar_function.php';
    session_start();

    // เช็คว่ามี session 'admin_id' หรือไม่
    if (isset($_SESSION['admin_id'])) {
        // ดึงค่า admin_id จาก session
        $admin_id = $_SESSION['admin_id'];

        // ดึงข้อมูลผู้ใช้จากฐานข้อมูล
        $querynew = "SELECT * FROM employee WHERE id = $admin_id";
        $resultnew = $conn->query($querynew);

        if ($resultnew->num_rows > 0) {
            $rownew = $resultnew->fetch_assoc();
            $username = $rownew['username'];
            $admin_level = $rownew['level'];
        }
    }
    include_once 'check_login_function.php';
    echo generateCheck($admin_level);
    echo generateNavbar();
    echo generateSidebar($username, $admin_level);
    ?>
    <div class="wrapper">
        <div class="content-wrapper">
                <div class="container pt-3">
                <div class="card ">
                    <div class="card-header " style="background-color:#2C3E50">
                        <h2 class="text-center text-light  pt-2 "> <i class="fa-solid fa-calendar-day me-2"></i>DETAIL-REPORT-ORDERS-SUCCESSFUL</h2>
                    </div>
                    <div class="card-body">                    
                                <div class="input-group mb-3 d-none">
                                    <div class="input-group-prepend ">
                                        <span class="input-group-text text-dark ip bg-warning">ID</span>
                                    </div>
                                    <input type="text" name="id" id="id" value="<?php echo $row['id']; ?>" class="form-control  ip" readonly>
                                </div>
                                <div class="input-group d-none">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>user_id</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="user_id" value="<?php echo $row['user_id']; ?>" readonly>
                                </div>

                                <div class="input-group mb-3">
                                <img class="image-preview border border-1 border-dark" src="slip/<?php echo $row['image_delivery']; ?>" alt="" width="150px" >
                            </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>บิล</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="slip_image" value="<?php echo $row['image_delivery']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เลขคำสั่งซื้อ</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="order_number" value="<?php echo $row['order_number']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อสินค้า</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="product_name" value="<?php echo $row['product_name']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ราคาสินค้า</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="product_price" value="<?php echo $row['product_price']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>จำนวนสินค้า</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="product_quantity" value="<?php echo $row['product_quantity']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ราคารวม</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="total_product_price" value="<?php echo $row['total_product_price']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เวลาสั่งซื้อ</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="created_at" value="<?php echo $row['created_at']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อผู้ใช้</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="username" value="<?php echo $row['username']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ชื่อผู้สั่งซื้อ</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="full_name" value="<?php echo $row['full_name']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>ที่อยู่</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="address" value="<?php echo $row['address']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light ip" id="basic-addon1"><b>เบอร์โทร</b></span>
                                    <input type="text" class="form-control ip" aria-label="product_amount" aria-describedby="basic-addon1" name="phone" value="<?php echo $row['phone']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>บริษัทขนส่ง</b></span>
                                    <input type="text" class="form-control " aria-label="" aria-describedby="basic-addon1" name="" value="<?php echo $row['delivery_name']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>เลขพัสดุ</b></span>
                                    <input type="text" class="form-control " aria-label="" aria-describedby="basic-addon1" name="" value="<?php echo $row['delivery_number']; ?>" readonly>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text bg-dark text-light " id="basic-addon1"><b>เวลาการส่งสำเร็จ</b></span>
                                    <input type="text" class="form-control " aria-label="" aria-describedby="basic-addon1" name="" value="<?php echo $row['sucessful_at']; ?>" readonly>
                                </div>
                          
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>